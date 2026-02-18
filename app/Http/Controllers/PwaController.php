<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PwaController extends Controller
{
    /**
     * عرض صفحة التثبيت
     */
    public function install()
    {
        return view('pwa.install');
    }
    
    /**
     * عرض صفحة Offline
     */
    public function offline()
    {
        return view('pwa.offline');
    }
    
    /**
     * الحصول على إعدادات PWA
     */
    public function manifest()
    {
        $manifest = [
            'name' => config('app.name', 'تطبيق التعلم الذكي'),
            'short_name' => 'التعلم',
            'description' => 'تطبيق تعليمي تفاعلي بتصميم عربي',
            'start_url' => '/',
            'display' => 'standalone',
            'background_color' => '#4f46e5',
            'theme_color' => '#4f46e5',
            'orientation' => 'portrait-primary',
            'lang' => 'ar',
            'dir' => 'rtl',
            'icons' => $this->getIcons(),
            'shortcuts' => $this->getShortcuts(),
        ];
        
        return response()->json($manifest);
    }
    
    /**
     * الحصول على أيقونات التطبيق
     */
    private function getIcons()
    {
        return [
            [
                'src' => '/icons/icon-72x72.png',
                'sizes' => '72x72',
                'type' => 'image/png',
                'purpose' => 'any maskable'
            ],
            [
                'src' => '/icons/icon-96x96.png',
                'sizes' => '96x96',
                'type' => 'image/png',
                'purpose' => 'any maskable'
            ],
            [
                'src' => '/icons/icon-128x128.png',
                'sizes' => '128x128',
                'type' => 'image/png',
                'purpose' => 'any maskable'
            ],
            [
                'src' => '/icons/icon-144x144.png',
                'sizes' => '144x144',
                'type' => 'image/png',
                'purpose' => 'any maskable'
            ],
            [
                'src' => '/icons/icon-152x152.png',
                'sizes' => '152x152',
                'type' => 'image/png',
                'purpose' => 'any maskable'
            ],
            [
                'src' => '/icons/icon-192x192.png',
                'sizes' => '192x192',
                'type' => 'image/png',
                'purpose' => 'any maskable'
            ],
            [
                'src' => '/icons/icon-384x384.png',
                'sizes' => '384x384',
                'type' => 'image/png',
                'purpose' => 'any maskable'
            ],
            [
                'src' => '/icons/icon-512x512.png',
                'sizes' => '512x512',
                'type' => 'image/png',
                'purpose' => 'any maskable'
            ],
        ];
    }
    
    /**
     * الحصول على الاختصارات
     */
    private function getShortcuts()
    {
        return [
            [
                'name' => 'الصفحة الرئيسية',
                'short_name' => 'الرئيسية',
                'description' => 'الذهاب إلى الصفحة الرئيسية',
                'url' => '/',
                'icons' => [
                    [
                        'src' => '/icons/home-icon.png',
                        'sizes' => '96x96'
                    ]
                ]
            ],
            [
                'name' => 'الإشعارات',
                'short_name' => 'إشعارات',
                'description' => 'عرض الإشعارات',
                'url' => '/notifications',
                'icons' => [
                    [
                        'src' => '/icons/bell-icon.png',
                        'sizes' => '96x96'
                    ]
                ]
            ],
            [
                'name' => 'الملف الشخصي',
                'short_name' => 'الملف',
                'description' => 'عرض الملف الشخصي',
                'url' => '/page/profile',
                'icons' => [
                    [
                        'src' => '/icons/user-icon.png',
                        'sizes' => '96x96'
                    ]
                ]
            ],
        ];
    }
    
    /**
     * إرسال إشعارات Push
     */
    public function sendNotification(Request $request)
    {
        // هذا مثال بسيط لإرسال إشعارات
        // في التطبيق الحقيقي ستحتاج إلى استخدام خدمة مثل Firebase Cloud Messaging
        
        $data = [
            'title' => $request->input('title', 'إشعار جديد'),
            'body' => $request->input('body', 'لديك إشعار جديد في تطبيق التعلم الذكي'),
            'icon' => '/icons/icon-192x192.png',
            'badge' => '/icons/icon-96x96.png',
            'dir' => 'rtl',
            'lang' => 'ar',
            'vibrate' => [200, 100, 200],
            'data' => [
                'url' => $request->input('url', '/')
            ]
        ];
        
        // هنا يمكنك إضافة منطق إرسال الإشعارات
        // return response()->json(['success' => true, 'data' => $data]);
        
        return response()->json([
            'success' => true,
            'message' => 'سيتم تنفيذ إرسال الإشعارات في الإصدار القادم'
        ]);
    }
    
    /**
     * التحقق من دعم PWA
     */
    public function checkSupport()
    {
        $supported = [
            'serviceWorker' => 'serviceWorker' in navigator,
            'pushNotifications' => 'PushManager' in window,
            'installPrompt' => 'beforeinstallprompt' in window,
            'standalone' => window.matchMedia('(display-mode: standalone)').matches,
        ];
        
        return response()->json($supported);
    }
}
