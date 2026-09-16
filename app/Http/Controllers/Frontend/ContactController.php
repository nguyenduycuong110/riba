<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use Illuminate\Http\Request;
use Jenssegers\Agent\Facades\Agent;
use Illuminate\Support\Facades\DB;
use App\Models\Contact;

use App\Services\V1\Core\WidgetService;

class ContactController extends FrontendController
{
    protected $language;
    protected $system;
    protected $widgetService;

    public function __construct(
        WidgetService $widgetService,
    ){
        $this->widgetService = $widgetService;
        parent::__construct(); 
    }


    public function index(Request $request){
        $widgets = $this->widgetService->getWidget([
            ['keyword' => 'showroom-system','object' => true],
            ['keyword' => 'news-outstanding','object' => true],
        ], $this->language);
        $config = $this->config();
        $system = $this->system;
        $seo = [
            'meta_title' => 'Trang Thông tin liên hệ',
            'meta_description' => 'Thông tin liên hệ của '.$system['homepage_company'],
            'meta_keyword' => '',
            'meta_image' => '',
            'canonical' => write_url('lien-he')
        ];
        $template = 'frontend.contact.index';
        return view($template, compact(
            'widgets',
            'config',
            'seo',
            'system',
        ));
    }

    public function save(Request $request){
        try {
            DB::beginTransaction();
            $payload = $request->only(['email', 'name', 'phone', 'address', 'message']);
            Contact::create($payload);
            DB::commit();
            return response()->json([
                'message' => 'success',
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
        
    }

    /**
     * Nhan form o trang lien-he.html.
     *
     * Truoc day method nay khong co route nao tro toi, ma form lai post len
     * url('contact/save') -> bam Xac nhan la 404.
     *
     * Ngoai ra no chi doc ['email','name','phone','address','message'], trong
     * khi form gui 'content' (Tieu de) va 'description' (Noi dung can ho tro).
     * Neu chi noi route ma khong sua cho nay thi hai o do bi vut di lang le:
     * lien he luu vao CSDL nhung khong co noi dung nguoi ta viet.
     */
    public function saveContact(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'content' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:5000',
        ], [
            'name.required' => 'Bạn chưa nhập họ tên.',
            'email.required' => 'Bạn chưa nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'phone.required' => 'Bạn chưa nhập số điện thoại.',
        ]);

        try {
            DB::beginTransaction();

            // Bang contacts khong co cot rieng cho tieu de / noi dung nen gop vao
            // 'message'. Phai escape: trang quan tri in cot nay bang {!! !!}
            // (khong escape), de nguyen thi noi dung nguoi dung gui thanh XSS
            // luu tru nham vao admin.
            $title = trim((string) ($validated['content'] ?? ''));
            $body = trim((string) ($validated['description'] ?? ''));

            $message = '';
            if ($title !== '') {
                $message .= '<div><strong>' . e($title) . '</strong></div>';
            }
            if ($body !== '') {
                $message .= '<div>' . nl2br(e($body)) . '</div>';
            }

            Contact::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'message' => $message,
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Gửi liên hệ thành công. Chúng tôi sẽ liên hệ lại trong thời gian sớm nhất.');
        } catch (\Throwable $th) {
            DB::rollBack();
            report($th);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra khi gửi liên hệ. Vui lòng thử lại.');
        }

    }

    private function config(){
        return [
            'language' => $this->language,
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'js' => [
                'backend/library/location.js',
                'frontend/core/library/cart.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
            ]
        ];
    }

}
