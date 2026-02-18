<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Student
    public function studentIndex()
    {
        return $this->show('student', 'home');
    }

    public function studentShow($page)
    {
        return $this->show('student', $page);
    }

    // Admin
    public function adminIndex()
    {
        return $this->show('admin', 'home');
    }

    public function adminShow($page)
    {
        return $this->show('admin', $page);
    }

    // Tash
    public function tashIndex()
    {
        return $this->show('tash', 'home');
    }

    public function tashShow($page)
    {
        return $this->show('tash', $page);
    }

    // Panorama
    public function panoramaIndex()
    {
        return $this->show('panorama', 'home');
    }

    public function panoramaShow($page)
    {
        return $this->show('panorama', $page);
    }

    // Ayham
    public function ayhamIndex()
    {
        return $this->show('ayham', 'home');
    }






    public function ayhamShow($page)
    {
        return $this->show('ayham', $page);
    }

    // الدالة المشتركة
    private function show($section, $page)
    {
        $pages = [
            'home' => ['title' => 'الصفحة الرئيسية', 'icon' => 'fas fa-home', 'color' => '#6366f1'],
            'explore' => ['title' => 'سجل الأعمال', 'icon' => 'fas fa-tasks', 'color' => '#8b5cf6'],
            'favorites' => ['title' => 'سجل المرضى', 'icon' => 'fas fa-folder-open', 'color' => '#f59e0b'],
            'profile' => ['title' => 'الملف الشخصي', 'icon' => 'fas fa-user', 'color' => '#10b981'],
            'cases' => ['title' => 'سجل الحالات', 'icon' => 'fas fa-file-medical', 'color' => '#3b82f6'],
            'manh-tables' => ['title' => 'سجل الحالات الممنوحة', 'icon' => 'fas fa-user', 'color' => '#8b5cf6'],
            'patients' => ['title' => 'سجل المرضى', 'icon' => 'fas fa-user-injured', 'color' => '#ef4444'],
            'add-case' => ['title' => 'إضافة حالة', 'icon' => 'fas fa-plus-circle', 'color' => '#06b6d4'],
        ];

        if (!array_key_exists($page, $pages)) {
            abort(404);
        }

        $navItems = [
            ['id' => 'home', 'icon' => 'fas fa-home', 'label' => 'الرئيسية'],
            ['id' => 'explore', 'icon' => 'fas fa-tasks', 'label' => 'سجل الأعمال'],
            ['id' => 'favorites', 'icon' => 'fas fa-folder-open', 'label' => 'سجل المرضى'],
            ['id' => 'profile', 'icon' => 'fas fa-user', 'label' => 'الملف الشخصي'],
            ['id' => 'cases', 'icon' => 'fas fa-file-medical', 'label' => 'الحالات'],
            ['id' => 'patients', 'icon' => 'fas fa-user-injured', 'label' => 'المرضى'],
            ['id' => 'add-case', 'icon' => 'fas fa-plus-circle', 'label' => 'إضافة حالة'],
        ];

        $filteredNavItems = $this->filterNavItems($section, $navItems);

        $viewPath = "{$section}.{$page}";
        
        // تحقق من وجود الـ view
        if (!view()->exists($viewPath)) {
            abort(404, "الصفحة غير موجودة: {$viewPath}");
        }

        return view($viewPath, [
            'page' => $pages[$page],
            'navItems' => $filteredNavItems,
            'currentPage' => $page,
            'section' => $section
        ]);
    }

    private function filterNavItems($section, $navItems)
    {
        $allowedItems = [
            'student' => ['home', 'explore', 'favorites', 'profile'],
            'admin' => ['home', 'explore', 'favorites', 'profile'],
            'tash' => ['home', 'cases', 'patients', 'profile', 'add-case'],
            'panorama' => ['home', 'explore', 'favorites', 'profile'],
            'ayham' => ['home', 'explore', 'favorites', 'profile'],
        ];

        $items = $allowedItems[$section] ?? ['home', 'profile'];
        
        return array_values(array_filter($navItems, function($item) use ($items) {
            return in_array($item['id'], $items);
        }));
    }
}
