<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use App\Http\Requests\AuthRegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail; 
use App\Models\Customer;
use App\Enums\SlideEnum;

use App\Services\V1\Customer\CustomerService;
use App\Services\V1\Core\SlideService;


class AuthController extends FrontendController
{
    protected $customerService;
    protected $slideService;
    public function __construct(
        CustomerService $customerService,
        SlideService $slideService,
    ){
        $this->customerService = $customerService;
        $this->slideService = $slideService;
        parent::__construct();
    }

    public function index(){
        $system = $this->system;
        $seo = [
            'meta_title' => 'Trang đăng nhập - Hệ thống website '.$this->system['homepage_company'],
            'meta_keyword' => '',
            'meta_description' => '',
            'meta_image' => '',
            'canonical' => route('fe.auth.login')
        ];
        return view('frontend.auth.index', compact(
            'seo',
            'system',
        ));
    }
  
    public function register(){
        $seo = [
            'meta_title' => 'Thông tin kích hoạt bảo hành',
            'meta_keyword' => '',
            'meta_description' => '',
            'meta_image' => '',
            'canonical' => ''
        ];
        $system = $this->system;
        $slides = $this->slideService->getSlide(
            [SlideEnum::WHYCHOOSE],
            $this->language
        );
        return view('frontend.auth.customer.register',compact(
            'seo',
            'system',
            'slides'
        ));
    }
    
    public function registerAccount(AuthRegisterRequest $request){
        if($this->customerService->create($request)){
           return redirect()->route('home.index')->with('success','Đăng kí tài khoản thành công');
        }
        return redirect()->route('customer.register')->with('error','Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function forgotCustomerPassword(){
        $seo = [
            'meta_title' => 'Quên mật khẩu',
            'meta_keyword' => '',
            'meta_description' => '',
            'meta_image' => '',
            'canonical' => route('forgot.customer.password')
        ];
        $route = 'customer.password.email';
        $system = $this->system;
        return view('frontend.auth.components.forgotPassword',compact(
            'seo',
            'system',
            'route'
        ));
    }

    public function verifyCustomerEmail(Request $request){
        $emailReset = $request->input('email');
        $customer = Customer::where('email', $emailReset)->first();
        if(!is_null($customer)){
            Mail::to($emailReset)->send(new ResetPasswordMail($emailReset));
            return redirect()->route('fe.auth.login')
            ->with('success','Gửi yêu cầu cập nhật mật khẩu thành công, vui lòng truy cập email của bạn để cập nhật mật khẩu mới');
        }
        return redirect()->route('forgot.customer.password')->with('error','Gửi yêu cầu cập nhật mật khẩu không thành công, email không tồn tại trong hệ thống');
    }


    public function updatePassword(Request $request){
        $email = rtrim(urldecode($request->getQueryString('email')), '=');
        $seo = [
            'meta_title' => 'Thông tin kích hoạt bảo hành',
            'meta_keyword' => '',
            'meta_description' => '',
            'meta_image' => '',
            'canonical' => route('customer.profile')
        ];
        $system = $this->system;
        $route = 'customer.password.reset';
        return view('frontend.auth.components.updatePassword',compact(
            'system',
            'seo',
            'route',
            'email'
        ));
    }
    
    public function changePassword(Request $request)
    {
        $email = base64_decode(rtrim(urldecode($request->getQueryString('email')), '='));
        $customer = Customer::where('email', $email)->first();

        if($this->customerService->update($customer->id, $request)) {
            return redirect()->route('fe.auth.login')->with('success', 'Cập nhật mật khẩu mới thành công');
        }
        return redirect()->route('customer.update.password')->with('error', 'Cập nhật mật khẩu không thành công. Hãy thử lại');
    }


    public function login(Request $request){
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];
        if(Auth::guard('customer')->attempt($credentials)){
            $user = Auth::guard('customer')->user();
            $request->session()->regenerate();
            return redirect()->route('home.index')->with('success', 'Đăng nhập thành công');
        }
        return redirect()->route('home.index')->with('error','Email hoặc Mật khẩu không chính xác');
    }


}
