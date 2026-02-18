<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $navItems = [
            ['id' => 'home', 'icon' => 'fas fa-home', 'label' => 'الرئيسية', 'active' => true],
            ['id' => 'explore', 'icon' => 'fas fa-tasks', 'label' => 'سجل الأغمال', 'active' => false],
            ['id' => 'favorites', 'icon' => 'fas fa-folder-open', 'label' => 'سجل المرضى', 'active' => false],
            ['id' => 'profile', 'icon' => 'fas fa-user', 'label' => 'الملف الشخصي', 'active' => false]
        ];
        
        return view('home', compact('navItems'));
    }
    
    public function show($page)
    {
        $pages = [
            'home' => ['title' => 'الصفحة الرئيسية', 'icon' => 'fas fa-home', 'color' => '#4f46e5'],
            'explore' => ['title' => 'سجل الأعمال', 'icon' => 'fas fa-tasks', 'color' => '#10b981'],
            'favorites' => ['title' => 'سجل المرضى', 'icon' => 'fas fa-folder-open', 'color' => '#ec4899'],
            'profile' => ['title' => 'الملف الشخصي', 'icon' => 'fas fa-user', 'color' => '#f59e0b']
        ];
        
        if (!array_key_exists($page, $pages)) {
            abort(404);
        }
        
        $navItems = [
            ['id' => 'home', 'icon' => 'fas fa-home', 'label' => 'الرئيسية', 'active' => ($page == 'home')],
            ['id' => 'explore', 'icon' => 'fas fa-tasks', 'label' => 'سجل الحالات', 'active' => ($page == 'explore')],
            ['id' => 'favorites', 'icon' => 'fas fa-folder-open', 'label' => 'سجل المرضى', 'active' => ($page == 'favorites')],
            ['id' => 'profile', 'icon' => 'fas fa-user', 'label' => 'الملف الشخصي', 'active' => ($page == 'profile')]
        ];
        
        if ($page == 'explore') {
            return view('explore', [
                'page' => $pages[$page],
                'navItems' => $navItems,
                'currentPage' => $page
            ]);
        }
        
        if ($page == 'favorites') {
            return view('favorites', [
                'page' => $pages[$page],
                'navItems' => $navItems,
                'currentPage' => $page
            ]);
        }
        
        if ($page == 'profile') {
            return view('profile', [
                'page' => $pages[$page],
                'navItems' => $navItems,
                'currentPage' => $page
            ]);
        }

        if ($page == 'home') {
            return view('home', [
                'page' => $pages[$page],
                'navItems' => $navItems,
                'currentPage' => $page
            ]);
        }

        return view('page', [
            'page' => $pages[$page],
            'navItems' => $navItems,
            'currentPage' => $page
        ]);
    }
}
