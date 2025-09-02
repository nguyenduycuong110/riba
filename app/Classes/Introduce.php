<?php
namespace App\Classes;

class Introduce{

    public function config(){
        $data['block_1'] = [
            'label' => 'Khối 1',
            'description' => 'Cài đặt đầy đủ thông tin khối dưới đây',
            'value' => [
                'title' => ['type' => 'text', 'label' => 'Tiêu đề khối'],
                'description' => ['type' => 'text', 'label' => 'Giới thiệu'],
                'number_1' => ['type' => 'text', 'label' => 'Số chuyên gia'],
                'number_2' => ['type' => 'text', 'label' => 'Số năm kinh nghiệm'],
                'number_3' => ['type' => 'text', 'label' => 'Số tổ chức hàng đầu'],
                'button_1' => ['type' => 'text', 'label' => 'Nút 1'],
                'button_1_link' => ['type' => 'text', 'label' => 'Link Nút 1'],
                'button_2' => ['type' => 'text', 'label' => 'Nút 2'],
                'button_2_link' => ['type' => 'text', 'label' => 'Link Nút 2'],
                'background' => ['type' => 'images', 'label' => 'Ảnh nền'],
            ]
        ];
        $data['block_2'] = [
            'label' => 'Khối 2: ',
            'description' => 'Cài đặt đầy đủ thông tin khối dưới đây',
            'value' => [
                'title' => ['type' => 'text', 'label' => 'Tiêu đề khối'],
                'text_1' => ['type' => 'text', 'label' => 'Text 1'],
                'text_2' => ['type' => 'text', 'label' => 'Text 2'],
                'text_3' => ['type' => 'text', 'label' => 'Text 3'],
                'image' => ['type' => 'images', 'label' => 'Hình Ảnh'],
                'button' => ['type' => 'text', 'label' => 'Tiêu đề nút'],
                'button_link' => ['type' => 'text', 'label' => 'Link Nút 2'],
                
            ]
        ];
        $data['block_3'] = [
            'label' => 'Khối 3: Nhiệm vụ sứ mệnh',
            'description' => 'Cài đặt đầy đủ thông tin khối dưới đây',
            'value' => [
                'title' => ['type' => 'text', 'label' => 'Tiêu đề khối'],
                'text_1' => ['type' => 'text', 'label' => 'Text 1'],
                'description_1' => ['type' => 'textarea', 'label' => 'Mô tả 1'],
                'text_2' => ['type' => 'text', 'label' => 'Text 2'],
                'description_2' => ['type' => 'textarea', 'label' => 'Mô tả 2'],
                'text_3' => ['type' => 'text', 'label' => 'Text 3'],
                'description_3' => ['type' => 'textarea', 'label' => 'Mô tả 3'],
                'text_4' => ['type' => 'text', 'label' => 'Text 4'],
                'description_4' => ['type' => 'textarea', 'label' => 'Mô tả 4'],
                
            ]
        ];
        $data['block_4'] = [
            'label' => 'Khối 4: Tại sao nên học cùng OME',
            'description' => 'Cài đặt đầy đủ thông tin khối dưới đây',
            'value' => [
                'title' => ['type' => 'text', 'label' => 'Tiêu đề khối'],
                'text_1' => ['type' => 'text', 'label' => 'Text 1'],
                'description_1' => ['type' => 'textarea', 'label' => 'Mô tả 1'],
                'image_1' => ['type' => 'images', 'label' => 'Ảnh 1'],
                'text_2' => ['type' => 'text', 'label' => 'Text 2'],
                'description_2' => ['type' => 'textarea', 'label' => 'Mô tả 2'],
                'image_2' => ['type' => 'images', 'label' => 'Ảnh 2'],
                'text_3' => ['type' => 'text', 'label' => 'Text 3'],
                'description_3' => ['type' => 'textarea', 'label' => 'Mô tả 3'],
                'image_3' => ['type' => 'images', 'label' => 'Ảnh 3'],
                'text_4' => ['type' => 'text', 'label' => 'Text 4'],
                'description_4' => ['type' => 'textarea', 'label' => 'Mô tả 4'],
                'image_4' => ['type' => 'images', 'label' => 'Ảnh 4'],
            ]
        ];
        $data['block_5'] = [
            'label' => 'Khối 5: Đối tượng tham gia',
            'description' => 'Cài đặt đầy đủ thông tin khối dưới đây',
            'value' => [
                'title' => ['type' => 'text', 'label' => 'Tiêu đề khối'],
                'text_1' => ['type' => 'text', 'label' => 'Text 1'],
                'image_1' => ['type' => 'images', 'label' => 'Ảnh 1'],
                'text_2' => ['type' => 'text', 'label' => 'Text 2'],
                'image_2' => ['type' => 'images', 'label' => 'Ảnh 2'],
                'text_3' => ['type' => 'text', 'label' => 'Text 3'],
                'image_3' => ['type' => 'images', 'label' => 'Ảnh 3'],
            ]
        ];
        return $data;
    }
	
}
