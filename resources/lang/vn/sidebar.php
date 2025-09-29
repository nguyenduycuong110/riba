<?php   
return [
    'module' => [
        [
            'title' => 'Dashboard',
            'icon' => 'fa fa-database',
            'name' => ['dashboard'],
            'route' => 'dashboard/index',
            'class' => 'special'
        ],
        // [
        //     'title' => 'Báo cáo doanh thu',
        //     'icon' => 'fa fa-money',
        //     'name' => ['report'],
        //     'subModule' => [
        //         [
        //             'title' => 'Theo thời gian',
        //             'route' => 'report/time'
        //         ],
        //         [
        //             'title' => 'Theo sản phẩm',
        //             'route' => 'report/product'
        //         ],
        //         [
        //             'title' => 'Theo nguồn khách',
        //             'route' => 'report/customer'
        //         ],
        //     ]
        // ],
        // [
        //     'title' => 'QL Sản Phẩm',
        //     'icon' => 'fa fa-cube',
        //     'name' => ['product','attribute'],
        //     'subModule' => [
        //         [
        //             'title' => 'QL Nhóm Sản Phẩm',
        //             'route' => 'product/catalogue/index'
        //         ],
        //         [
        //             'title' => 'QL Sản phẩm',
        //             'route' => 'product/index'
        //         ],
        //         [
        //             'title' => 'QL Loại thuộc tính',
        //             'route' => 'attribute/catalogue/index'
        //         ],
        //         [
        //             'title' => 'QL thuộc tính',
        //             'route' => 'attribute/index'
        //         ],

        //     ]
        // ],
        // [
        //     'title' => 'QL đơn hàng',
        //     'icon' => 'fa fa-shopping-bag',
        //     'name' => ['order'],
        //     'subModule' => [
        //         [
        //             'title' => 'QL Đơn Hàng',
        //             'route' => 'order/index'
        //         ],
        //     ]
        // ],
        // [
        //     'title' => 'QL Nhóm Khách hàng',
        //     'icon' => 'fa fa-user',
        //     'name' => ['customer'],
        //     'subModule' => [
        //         [
        //             'title' => 'QL Nhóm Khách hàng',
        //             'route' => asset('customer/catalogue/index')
        //         ],
        //         [
        //             'title' => 'QL Khách hàng',
        //             'route' => 'customer/index'
        //         ],
        //     ]
        // ],
        // [
        //     'title' => 'QL Marketing',
        //     'icon' => 'fa fa-money',
        //     'name' => ['promotion', 'source'],
        //     'subModule' => [
        //         [
        //             'title' => 'QL Khuyến mại',
        //             'route' => 'promotion/index'
        //         ],
        //         [
        //             'title' => 'QL Voucher',
        //             'route' => 'voucher/index'
        //         ],
        //         [
        //             'title' => 'QL nguồn khách',
        //             'route' => 'source/index'
        //         ],
        //     ]
        // ],
        [
            'title' => 'QL Bài viết',
            'icon' => 'fa fa-file',
            'name' => ['post'],
            'subModule' => [
                [
                    'title' => 'QL Nhóm Bài Viết',
                    'route' => 'post/catalogue/index'
                ],
                [
                    'title' => 'QL Bài Viết',
                    'route' => 'post/index'
                ]
            ]
        ],
        // [
        //     'title' => 'QL Bình Luận',
        //     'icon' => 'fa fa-comment',
        //     'name' => ['reviews'],
        //     'subModule' => [
        //         [
        //             'title' => 'QL Bình Luận',
        //             'route' => 'review/index'
        //         ]
        //     ]
        // ],
        [
            'title' => 'QL Liên Hệ',
            'icon' => 'fa fa-github',
            'name' => ['contacts'],
            'subModule' => [
                [
                    'title' => 'QL Liên Hệ',
                    'route' => 'contact/index'
                ]
            ]
        ],
        [
            'title' => 'QL Nhóm Thành Viên',
            'icon' => 'fa fa-user',
            'name' => ['user','permission'],
            'subModule' => [
                [
                    'title' => 'QL Nhóm Thành Viên',
                    'route' => 'user/catalogue/index'
                ],
                [
                    'title' => 'QL Thành Viên',
                    'route' => 'user/index'
                ],
                [
                    'title' => 'QL Quyền',
                    'route' => 'permission/index'
                ]
            ]
        ],
        [
            'title' => 'Giới thiệu',
            'icon' => 'fa fa-user',
            'name' => ['introduce'],
            'route' => 'introduce/index'
        ],
        // [
        //     'title' => 'QL Trường',
        //     'icon' => 'fa fa-instagram',
        //     'name' => ['school', 'area', 'project'],
        //     'subModule' => [
        //         [
        //             'title' => 'Quản lý loại hình trường',
        //             'route' => 'school/catalogue/index'
        //         ],
        //         [
        //             'title' => 'Quản lý trường',
        //             'route' => 'school/index'
        //         ],
        //         [
        //             'title' => 'Quản lý khu vực',
        //             'route' => 'area/index'
        //         ],
        //         [
        //             'title' => 'Quản lý thành phố',
        //             'route' => 'city/index'
        //         ],
        //         [
        //             'title' => 'Quản lý dự án',
        //             'route' => 'project/index'
        //         ],
        //     ]
        // ],
        [
            'title' => 'QL Trường',
            'icon' => 'fa fa-github',
            'name' => ['school', 'school_catalogue'],
            'subModule' => [
                [
                    'title' => 'QL Loại Trường',
                    'route' => 'school_catalogue/index'
                ],
                [
                    'title' => 'QL Trường',
                    'route' => 'school/index'
                ],
                [
                    'title' => 'QL Khu Vực',
                    'route' => 'school/area/index'
                ],
                [
                    'title' => 'QL Thành Phố',
                    'route' => 'school/city/index'
                ],
                [
                    'title' => 'QL Dự Án',
                    'route' => 'school/project/index'
                ],
            ]
        ],
        [
            'title' => 'QL Chuyên Ngành',
            'icon' => 'fa fa-database',
            'name' => ['major', 'major_catalogue'],
            'subModule' => [
                [
                    'title' => 'Nhóm Ngành',
                    'route' => 'major_group/index'
                ],
                [
                    'title' => 'Ngành',
                    'route' => 'major_catalogue/index'
                ],
                [
                    'title' => 'Chuyên Ngành',
                    'route' => 'major/index'
                ],
            ]
        ],
        [
            'title' => 'QL Học bổng',
            'icon' => 'fa fa-github',
            'name' => ['scholar'],
            'subModule' => [
                [
                    'title' => 'QL Học Bổng',
                    'route' => 'scholar/index'
                ],
                [
                    'title' => 'QL Loại Học Bổng',
                    'route' => 'scholar/catalogue/index'
                ],
                [
                    'title' => 'QL Chính Sách',
                    'route' => 'scholar/policy/index'
                ],
                [
                    'title' => 'QL Hệ Đào Tạo',
                    'route' => 'scholar/train/index'
                ],
            ]
        ],
        [
            'title' => 'QL Tuyển Sinh',
            'icon' => 'fa fa-instagram',
            'name' => ['admission'],
            'subModule' => [
                [
                    'title' => 'QL Tuyển Sinh',
                    'route' => 'admission/index'
                ],
                [
                    'title' => 'QL Loại Tuyển Sinh',
                    'route' => 'admission/catalogue/index'
                ],
            ]
        ],
        [
            'title' => 'QL Banner & Slide',
            'icon' => 'fa fa-picture-o',
            'name' => ['slide'],
            'subModule' => [
                [
                    'title' => 'Cài đặt Slide',
                    'route' => 'slide/index'
                ],
            ]
        ],
        [
            'title' => 'QL Menu',
            'icon' => 'fa fa-bars',
            'name' => ['menu'],
            'subModule' => [
                [
                    'title' => 'Cài đặt Menu',
                    'route' => 'menu/index'
                ],
            ]
        ],
        [
            'title' => 'Cấu hình chung',
            'icon' => 'fa fa-file',
            'name' => ['language', 'generate', 'system', 'widget'],
            'subModule' => [
                [
                    'title' => 'QL Ngôn ngữ',
                    'route' => 'language/index'
                ],
                [
                    'title' => 'Cấu hình hệ thống',
                    'route' => 'system/index'
                ],
                [
                    'title' => 'Quản lý Widget',
                    'route' => 'widget/index'
                ],
                
            ]
        ]
    ],
];
