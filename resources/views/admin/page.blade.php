@extends('layouts.app')

@section('title', $page['title'])

@section('content')
<div class="header">
    <div class="card-icon" style="background: {{ $page['color'] }}20; color: {{ $page['color'] }}; display: inline-flex; width: 60px; height: 60px; margin-bottom: 16px;">
        <i class="{{ $page['icon'] }}" style="font-size: 28px;"></i>
    </div>
    <h1>{{ $page['title'] }}</h1>
    <p>أنت الآن في صفحة {{ $page['title'] }}</p>
</div>

@for($i = 1; $i <= 8; $i++)
<div class="card interactive" style="margin-bottom: 16px;">
    <h3>عنصر رقم {{ $i }}</h3>
    <p>هذا محتوى اختباري للسماح بالـ Scroll في صفحة {{ $page['title'] }}. يمكنك التمرير لأسفل لمشاهدة المزيد من المحتوى.</p>
    
    @if($i % 2 == 0)
    <div style="display: flex; gap: 10px; margin-top: 10px;">
        <span style="background: {{ $page['color'] }}20; color: {{ $page['color'] }}; padding: 4px 12px; border-radius: 20px; font-size: 12px;">
            تاج {{ $i }}
        </span>
        <span style="background: rgba(0,0,0,0.05); color: var(--gray); padding: 4px 12px; border-radius: 20px; font-size: 12px;">
            محتوى
        </span>
    </div>
    @endif
</div>
@endfor

<div class="card" style="margin-top: 20px; margin-bottom: 40px; text-align: center;">
    <h3>نهاية المحتوى</h3>
    <p style="color: var(--gray);">
        وصلت إلى نهاية محتوى هذه الصفحة. يمكنك العودة للأعلى أو التوجه إلى صفحة أخرى.
    </p>
    <div style="margin-top: 15px;">
        <span style="display: inline-block; width: 40px; height: 4px; background: var(--gray); border-radius: 2px; opacity: 0.3;"></span>
    </div>
</div>

<script>
// تأثير بسيط عند تحميل الصفحة
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(() => {
        document.querySelector('.header').style.animation = 'fadeIn 0.5s ease';
    }, 100);
});
</script>
@endsection
