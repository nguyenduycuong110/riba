<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SchoolArea;
use App\Models\SchoolCity;
use Illuminate\Support\Facades\DB;

class ImportSchoolCities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'school:import-cities';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import cities data for schools based on areas';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Bắt đầu import dữ liệu thành phố...');

        // Dữ liệu thành phố theo khu vực
        $data = $this->getCitiesData();
        
        // Lấy user_id mặc định (user đầu tiên)
        $firstUser = DB::table('users')->first();
        $userId = $firstUser ? $firstUser->id : 1;
        
        if (!$firstUser) {
            $this->error('Không tìm thấy user nào trong database!');
            return Command::FAILURE;
        }

        $totalImported = 0;
        $totalSkipped = 0;
        $errors = [];

        foreach ($data as $areaName => $cities) {
            // Tìm area trong database (tìm theo tên không phân biệt hoa thường)
            $area = SchoolArea::whereRaw('LOWER(name) = ?', [mb_strtolower(trim($areaName))])->first();
            
            if (!$area) {
                $errors[] = "Không tìm thấy khu vực: {$areaName}";
                $this->warn("⚠ Không tìm thấy khu vực: {$areaName}");
                continue;
            }

            $this->info("📦 Đang xử lý khu vực: {$areaName} (ID: {$area->id})");

            foreach ($cities as $cityName) {
                $cityName = trim($cityName);
                if (empty($cityName)) {
                    continue;
                }

                // Kiểm tra xem thành phố đã tồn tại chưa (trong cùng khu vực)
                $existingCity = SchoolCity::where('area_id', $area->id)
                    ->whereRaw('LOWER(name) = ?', [mb_strtolower($cityName)])
                    ->first();

                if ($existingCity) {
                    $this->line("  ⏭ Bỏ qua (đã tồn tại): {$cityName}");
                    $totalSkipped++;
                    continue;
                }

                // Tạo thành phố mới
                try {
                    SchoolCity::create([
                        'area_id' => $area->id,
                        'name' => $cityName,
                        'publish' => 1,
                        'order' => 0,
                        'user_id' => $userId,
                    ]);

                    $this->line("  ✅ Đã thêm: {$cityName}");
                    $totalImported++;
                } catch (\Exception $e) {
                    $errors[] = "Lỗi khi thêm {$cityName}: " . $e->getMessage();
                    $this->error("  ❌ Lỗi khi thêm {$cityName}: " . $e->getMessage());
                }
            }
        }

        // Hiển thị kết quả
        $this->newLine();
        $this->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
        $this->info("✨ Hoàn thành import dữ liệu!");
        $this->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
        $this->info("✅ Đã thêm: {$totalImported} thành phố");
        $this->info("⏭ Đã bỏ qua: {$totalSkipped} thành phố (đã tồn tại)");
        
        if (count($errors) > 0) {
            $this->error("❌ Có " . count($errors) . " lỗi:");
            foreach ($errors as $error) {
                $this->error("  - {$error}");
            }
        }

        return Command::SUCCESS;
    }

    /**
     * Lấy dữ liệu thành phố theo khu vực
     */
    private function getCitiesData(): array
    {
        return [
            'Giang tô' => [
                'Nam Kinh',
                'Tô Châu',
                'Vô Tích',
                'Thái Châu',
                'Trấn Giang',
                'Dương Châu',
                'Nam Thông',
                'Liên Vân Cảng',
                'Túc Thiên',
                'Từ Châu',
                'Hoài An',
                'Hứa Xương',
            ],
            'Chiết Giang' => [
                'Hàng Châu',
                'Ninh Ba',
                'Ôn Châu',
                'Thiệu Hưng',
                'Kim Hoa',
                'Hồ Châu',
                'Gia Hưng',
                'Lệ Thủy',
                'Châu Sơn',
            ],
            'An Huy' => [
                'Hợp Phì',
                'Bạng Phụ',
                'Hoài Nam',
                'Hoài Bắc',
                'Túc Châu',
                'Hứa Châu',
                'An Khánh',
                'Hoàng Sơn',
                'Phụ Dương',
                'Trì Châu',
            ],
            'Phúc Kiến' => [
                'Phúc Châu',
                'Hạ Môn',
                'Tuyền Châu',
                'Chương Châu',
                'Nam Bình',
                'Long Nham',
                'Phủ Điền',
            ],
            'Sơn Đông' => [
                'Tế Nam',
                'Thanh Đảo',
                'Yên Đài',
                'Nhật Chiếu',
                'Uy Hải',
                'Truy Bác',
                'Duy Phường',
                'Bân Châu',
                'Lai Tân',
                'Đức Châu',
                'Hạ Trạch',
            ],
            'Hà Nam' => [
                'Trịnh Châu',
                'Tín Dương',
                'Nam Dương',
                'Tân Dư',
                'Tân Hương',
                'Giang Thành',
                'Phủ Châu',
                'Khai Phong',
                'Lạc Dương',
                'Tam Môn Hiệp',
            ],
            'Hồ Bắc' => [
                'Vũ Hán',
                'Kinh Châu',
                'Hoàng Thạch',
                'Hoàng Cương',
                'Nghi Xương',
                'Tiềm Giang',
                'Tùy Châu',
                'Thiềm Tây',
            ],
            'Hồ Nam' => [
                'Trường Sa',
                'Hành Dương',
                'Quế Lâm',
                'Tương Đàm',
                'Thiệu Dương',
                'Vĩnh Châu',
                'Miên Dương',
            ],
            'Giang Tây' => [
                'Nam Xương',
                'Cám Châu',
                'Cửu Giang',
                'Thượng Nhiêu',
                'Pingxiang – Bình Hương',
                'Tân Dư',
                'Nghi Xuân',
            ],
            'Hà Bắc' => [
                'Thạch Gia Trang',
                'Đường Sơn',
                'Tần Hoàng Đảo',
                'Bảo Định',
                'Thừa Đức',
                'Cang Châu',
                'Hành Thủy',
                'Lang Phường',
                'Hình Đài',
            ],
            'Sơn Tây' => [
                'Thái Nguyên',
                'Đại Đồng',
                'Trường Trị',
                'Lữ Lương',
                'Sóc Châu',
                'Vận Thành',
                'Lâm Phần',
                'Dương Tuyền',
            ],
            'Nội Mông' => [
                'Bao Đầu',
                'Hô Luân Bối Nhĩ',
                'Ô Lỗ Mộc Tề',
                'Thông Liêu',
                'Xích Phong',
                'Ordos',
                'Hô Hoà Hạo Đặc',
            ],
            'Liêu Ninh' => [
                'Thẩm Dương',
                'Đại Liên',
                'An Sơn',
                'Phủ Thuận',
                'Liêu Dương',
                'Doanh Khẩu',
                'Bản Khê',
                'Cẩm Châu',
            ],
            'Cát Lâm' => [
                'Trường Xuân',
                'Cát Lâm',
                'Liêu Nguyên',
                'Tùng Nguyên',
            ],
            'Hắc Long Giang' => [
                'Cáp Nhĩ Tân',
                'Mẫu Đơn Giang',
                'Hắc Hà',
                'Tề Tề Cáp Nhĩ',
                'Giai Mộc Tư',
            ],
            'Tứ Xuyên' => [
                'Thành Đô',
                'Miên Dương',
                'Đức Dương',
                'Lạc Sơn',
                'Tự Cống',
                'Nam Sung',
                'Á Nhĩ',
                'Nội Giang',
                'Kê Tây',
            ],
            'Trùng Khánh' => [
                'Trùng Khánh',
            ],
            'Quý Châu' => [
                'Quý Dương',
                'An Thuận',
                'Túc Châu',
                'Đồng Nhân',
                'Lục An',
            ],
            'Vân Nam' => [
                'Côn Minh',
                'Lệ Giang',
                'Bảo Sơn',
                'Đại Lý',
                'Phổ Nhĩ',
                'Ngọc Lâm',
                'Chiêu Thông',
                'Hồng Hà',
            ],
            'Thiểm Tây' => [
                'Tây An',
                'Diên An',
                'An Khang',
                'Hán Trung',
                'Bảo Kê',
                'Du Lâm',
                'Đồng Xuyên',
            ],
            'Cam Túc' => [
                'Lan Châu',
                'Tửu Tuyền',
                'Bạch Ngân',
                'Thiên Thuỷ',
                'Long Nam',
            ],
            'Thanh Hải' => [
                'Tây Ninh',
                'Hải Đông',
            ],
            'Tân Cương' => [
                'Ô Lỗ Mộc Tề',
                'Ích Dương',
                'A Lạp Nhĩ',
                'A Khắc Tô',
                'Khâm Châu',
            ],
            'Ninh Hạ' => [
                'Ngân Xuyên',
                'Thạch Chủy Sơn',
            ],
            'Quảng Đông' => [
                'Quảng Châu',
                'Thâm Quyến',
                'Phật Sơn',
                'Đông Hoản',
                'Sán Đầu',
                'Sán Vĩ',
                'Huệ Châu',
                'Dương Giang',
                'Khâm Châu',
                'Giang Môn',
                'Triệu Khánh',
                'Mậu Danh',
                'Liễu Châu',
            ],
            'Quảng Tây' => [
                'Nam Ninh',
                'Quế Lâm',
                'Bách Sắc',
                'Liễu Châu',
                'Ngọc Lâm',
                'Sùng Tả',
            ],
            'Hải Nam' => [
                'Hải Khẩu',
                'Tam Á',
                'Quỳnh Hải',
            ],
        ];
    }
}

