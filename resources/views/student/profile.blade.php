@extends('layouts.app')

@section('title', 'الملف الشخصي')
@section('page_title', 'الملف الشخصي')

@section('content')
<div class="profile-container">
    <!-- رأس الملف الشخصي -->
    <div class="profile-header" style="text-align: center; margin-bottom: 28px; padding: 24px 0;">
        <!-- الصورة الرمزية -->
        <div style="position: relative; display: inline-block; margin-bottom: 24px;">
            <div style="width: 110px; height: 110px; background: linear-gradient(145deg, var(--primary), var(--primary-light), var(--accent));
                        border-radius: 50%; display: flex; align-items: center; justify-content: center;
                        border: 4px solid white; box-shadow: 0 8px 30px rgba(79, 70, 229, 0.25);">
                <div style="color: white; font-size: 40px; font-weight: 700; font-family: 'Cairo', sans-serif; text-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    أ
                </div>
            </div>

            <!-- أيقونة التعديل -->
            <button onclick="changeProfilePicture()"
                    style="position: absolute; bottom: 4px; left: 4px; background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white;
                           border: 3px solid white; border-radius: 50%; width: 34px; height: 34px;
                           display: flex; align-items: center; justify-content: center; cursor: pointer;
                           box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3); transition: all 0.2s;">
                <i class="fas fa-camera" style="font-size: 13px;"></i>
            </button>
        </div>

        <!-- الاسم والمعلومات -->
        <h1 style="font-size: 24px; color: var(--dark); margin-bottom: 10px; font-weight: 800; line-height: 1.3; letter-spacing: -0.5px;">
            أيهم رياض حمشدو
        </h1>
        <div style="display: inline-flex; align-items: center; background: rgba(79, 70, 229, 0.08);
                    color: var(--primary); padding: 8px 18px; border-radius: 20px; font-size: 14px; margin-bottom: 14px; font-weight: 600;">
            <i class="fas fa-id-card" style="margin-left: 8px;"></i>
            212216
        </div>
        <div style="color: var(--gray-dark); font-size: 14px; margin-bottom: 18px; display: flex; align-items: center; justify-content: center; gap: 8px; flex-wrap: wrap; padding: 0 20px;">
            <i class="fas fa-graduation-cap" style="color: var(--primary);"></i>
            <span>طالب - كلية طب الأسنان - السنة الثالثة</span>
        </div>

        <!-- شارة الحالة -->
        <div style="display: inline-flex; align-items: center; background: rgba(16, 185, 129, 0.1);
                    color: var(--secondary); padding: 10px 20px; border-radius: 25px; font-size: 13px; font-weight: 600; gap: 8px;">
            <div style="width: 8px; height: 8px; background: var(--secondary); border-radius: 50%; box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);"></div>
            الحساب مفعل
        </div>
    </div>

    <!-- خط فاصل -->
    <div class="section-divider"></div>

    <!-- قسم الاستطلاعات والشكاوى -->
    <div class="input-container" style="margin-bottom: 20px; border-radius: var(--radius-lg); overflow: hidden; position: relative;">
        <div class="section-title" style="padding-bottom: 14px; border-bottom: 1px solid rgba(79, 70, 229, 0.1);">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 36px; height: 36px; background: linear-gradient(135deg, rgba(79, 70, 229, 0.15), rgba(236, 72, 153, 0.1));
                          border-radius: 10px; display: flex; align-items: center; justify-content: center;
                          box-shadow: 0 2px 8px rgba(79, 70, 229, 0.15);">
                    <i class="fas fa-chart-pie" style="color: var(--primary); font-size: 15px;"></i>
                </div>
                <div>
                    <div style="font-size: 15px; font-weight: 700; color: var(--dark);">الاستطلاعات والتقارير</div>
                    <div style="font-size: 11px; color: var(--gray);">شارك برأيك وساهم في التطوير</div>
                </div>
            </div>
        </div>

        <div class="horizontal-scroll-container" style="margin: 0 -22px; padding: 0 22px;">
            <div class="horizontal-cards surveys-cards" style="padding: 16px 4px 8px; gap: 12px;">
                <!-- زر الاستبيانات -->
                <button class="feature-card survey-card" onclick="openSurveys()" style="border: 1.5px solid rgba(79, 70, 229, 0.15); padding: 18px 16px; min-width: 150px; width: 150px; flex-shrink: 0; position: relative; overflow: hidden;">
                    <div style="position: absolute; top: -20px; left: -20px; width: 60px; height: 60px; background: linear-gradient(135deg, rgba(79, 70, 229, 0.1), transparent); border-radius: 50%;"></div>
                    <div style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(79, 70, 229, 0.15), rgba(79, 70, 229, 0.05));
                                  border-radius: 14px; display: flex; align-items: center; justify-content: center;
                                  box-shadow: 0 4px 12px rgba(79, 70, 229, 0.15);">
                            <i class="fas fa-clipboard-list" style="color: var(--primary); font-size: 20px;"></i>
                        </div>
                        <div style="text-align: center;">
                            <div style="font-size: 14px; font-weight: 700; color: var(--dark); margin-bottom: 4px;">الاستبيانات</div>
                            <div style="display: inline-flex; align-items: center; gap: 4px; background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white; padding: 3px 10px; border-radius: 12px; font-size: 11px; font-weight: 600;">
                                <span>2</span>
                                <span>جديد</span>
                            </div>
                        </div>
                    </div>
                </button>

                <!-- زر الشكاوى -->
                <button class="feature-card survey-card" onclick="openComplaints()" style="border: 1.5px solid rgba(16, 185, 129, 0.15); padding: 18px 16px; min-width: 150px; width: 150px; flex-shrink: 0; position: relative; overflow: hidden;">
                    <div style="position: absolute; top: -20px; left: -20px; width: 60px; height: 60px; background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), transparent); border-radius: 50%;"></div>
                    <div style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(16, 185, 129, 0.05));
                                  border-radius: 14px; display: flex; align-items: center; justify-content: center;
                                  box-shadow: 0 4px 12px rgba(16, 185, 129, 0.15);">
                            <i class="fas fa-comment-medical" style="color: var(--secondary); font-size: 20px;"></i>
                        </div>
                        <div style="text-align: center;">
                            <div style="font-size: 14px; font-weight: 700; color: var(--dark); margin-bottom: 4px;">الشكاوى</div>
                            <div style="font-size: 11px; color: var(--secondary); font-weight: 600;">قدم شكواك</div>
                        </div>
                    </div>
                </button>

                <!-- زر التقارير -->
                <button class="feature-card survey-card" onclick="openReports()" style="border: 1.5px solid rgba(245, 158, 11, 0.15); padding: 18px 16px; min-width: 150px; width: 150px; flex-shrink: 0; position: relative; overflow: hidden;">
                    <div style="position: absolute; top: -20px; left: -20px; width: 60px; height: 60px; background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), transparent); border-radius: 50%;"></div>
                    <div style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(245, 158, 11, 0.15), rgba(245, 158, 11, 0.05));
                                  border-radius: 14px; display: flex; align-items: center; justify-content: center;
                                  box-shadow: 0 4px 12px rgba(245, 158, 11, 0.15);">
                            <i class="fas fa-file-alt" style="color: var(--warning); font-size: 20px;"></i>
                        </div>
                        <div style="text-align: center;">
                            <div style="font-size: 14px; font-weight: 700; color: var(--dark); margin-bottom: 4px;">التقارير</div>
                            <div style="font-size: 11px; color: var(--warning); font-weight: 600;">عرض التقارير</div>
                        </div>
                    </div>
                </button>

                <!-- زر الاقتراحات -->
                <button class="feature-card survey-card" onclick="openSuggestions()" style="border: 1.5px solid rgba(236, 72, 153, 0.15); padding: 18px 16px; min-width: 150px; width: 150px; flex-shrink: 0; position: relative; overflow: hidden;">
                    <div style="position: absolute; top: -20px; left: -20px; width: 60px; height: 60px; background: linear-gradient(135deg, rgba(236, 72, 153, 0.1), transparent); border-radius: 50%;"></div>
                    <div style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(236, 72, 153, 0.15), rgba(236, 72, 153, 0.05));
                                  border-radius: 14px; display: flex; align-items: center; justify-content: center;
                                  box-shadow: 0 4px 12px rgba(236, 72, 153, 0.15);">
                            <i class="fas fa-lightbulb" style="color: var(--accent); font-size: 20px;"></i>
                        </div>
                        <div style="text-align: center;">
                            <div style="font-size: 14px; font-weight: 700; color: var(--dark); margin-bottom: 4px;">الاقتراحات</div>
                            <div style="font-size: 11px; color: var(--accent); font-weight: 600;">شارك فكرتك</div>
                        </div>
                    </div>
                </button>
            </div>
        </div>
        <!-- مؤشر التقدم -->
        <div class="scroll-indicator">
            <div class="scroll-progress"></div>
        </div>
        <!-- تلميح السحب -->
        <div class="scroll-hint">
            <i class="fas fa-hand-point-left"></i>
            <span>اسحب لمشاهدة المزيد</span>
        </div>
    </div>

    <!-- خط فاصل -->
    <div class="section-divider"></div>

    <!-- قسم المعلومات الإضافية المحسنة -->
    <div class="input-container" style="margin-bottom: 20px; border-radius: var(--radius-lg); overflow: hidden;">
        <div class="section-title" style="padding-bottom: 16px; border-bottom: 2px solid rgba(16, 185, 129, 0.1);">
            <div style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 36px; height: 36px; background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(16, 185, 129, 0.05));
                              border-radius: 10px; display: flex; align-items: center; justify-content: center;
                              box-shadow: 0 2px 8px rgba(16, 185, 129, 0.15);">
                        <i class="fas fa-user-circle" style="color: var(--secondary); font-size: 16px;"></i>
                    </div>
                    <div>
                        <div style="font-size: 16px; font-weight: 700; color: var(--dark);">معلومات التواصل</div>
                        <div style="font-size: 12px; color: var(--gray);">معلومات الاتصال والتواصل</div>
                    </div>
                </div>
                <button onclick="editContactInfo()" 
                        style="background: rgba(79, 70, 229, 0.1); color: var(--primary); border: none; 
                               padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; 
                               cursor: pointer; display: flex; align-items: center; gap: 6px;">
                    <i class="fas fa-edit" style="font-size: 12px;"></i>
                    تعديل
                </button>
            </div>
        </div>
        
        <div style="padding: 20px 0;">
            <!-- بطاقة البريد الإلكتروني -->
            <div class="info-card" style="margin-bottom: 16px;">
                <div style="display: flex; align-items: center; gap: 12px; padding: 16px; 
                          border-radius: var(--radius); background: white; border: 1.5px solid rgba(79, 70, 229, 0.1);">
                    <div style="width: 44px; height: 44px; background: linear-gradient(135deg, rgba(79, 70, 229, 0.1), rgba(79, 70, 229, 0.2)); 
                              border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="fas fa-envelope" style="color: var(--primary); font-size: 18px;"></i>
                    </div>
                    <div style="flex: 1; text-align: right;">
                        <div style="font-size: 12px; color: var(--gray); margin-bottom: 4px; font-weight: 500;">
                            <i class="fas fa-at" style="margin-left: 4px;"></i>
                            البريد الإلكتروني
                        </div>
                        <div style="font-size: 15px; font-weight: 700; color: var(--dark); direction: ltr; text-align: left;">
                            ayham.hamchado@edu.sy
                        </div>
                    </div>
                    <div style="width: 8px; height: 8px; background: var(--secondary); border-radius: 50%; 
                              box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);"></div>
                </div>
            </div>
            
            <!-- بطاقة رقم الهاتف مع إمكانية التعديل -->
            <div class="info-card" id="phoneCard">
                <!-- عرض الرقم الحالي -->
                <div id="phoneDisplayCard" style="display: flex; align-items: center; gap: 12px; padding: 16px;
                          border-radius: var(--radius); background: white; border: 1.5px solid rgba(16, 185, 129, 0.1);">
                    <div style="width: 44px; height: 44px; background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(16, 185, 129, 0.2));
                              border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="fas fa-mobile-alt" style="color: var(--secondary); font-size: 18px;"></i>
                    </div>
                    <div style="flex: 1; text-align: right;">
                        <div style="font-size: 12px; color: var(--gray); margin-bottom: 4px; font-weight: 500;">
                            <i class="fas fa-phone" style="font-size: 10px; margin-left: 4px;"></i>
                            رقم الهاتف
                        </div>
                        <div id="phoneDisplay" style="font-size: 16px; font-weight: 700; color: var(--dark); direction: ltr; text-align: left;">
                            0912345678
                        </div>
                        <div id="phoneChangesLeft" style="font-size: 10px; color: var(--warning); margin-top: 4px;">
                            <i class="fas fa-info-circle" style="margin-left: 4px;"></i>
                            3 تغييرات متبقية
                        </div>
                    </div>
                    <button onclick="editPhoneNumber()"
                            id="phoneEditBtn"
                            style="background: rgba(16, 185, 129, 0.1); color: var(--secondary); border: none;
                                   width: 36px; height: 36px; border-radius: 50%; display: flex;
                                   align-items: center; justify-content: center; cursor: pointer; flex-shrink: 0;">
                        <i class="fas fa-edit" style="font-size: 13px;"></i>
                    </button>
                </div>

                <!-- نموذج تعديل الرقم -->
                <div id="phoneEditForm" style="display: none; padding: 16px; border-radius: var(--radius); background: white; border: 1.5px solid rgba(79, 70, 229, 0.15);">
                    <div style="font-size: 14px; font-weight: 600; color: var(--dark); margin-bottom: 12px;">
                        <i class="fas fa-edit" style="color: var(--primary); margin-left: 6px;"></i>
                        تعديل رقم الهاتف
                    </div>
                    <div style="margin-bottom: 12px;">
                        <label style="font-size: 11px; color: var(--gray); margin-bottom: 6px; display: block;">
                            أدخل الرقم الجديد (8 أرقام بعد 09)
                        </label>
                        <div style="display: flex; align-items: center; gap: 0; direction: ltr;">
                            <span style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); padding: 10px 12px; border-radius: 8px 0 0 8px; font-weight: 700; color: white; font-size: 14px; white-space: nowrap; border: 2px solid var(--primary); border-right: none;">09</span>
                            <input type="tel"
                                   id="newPhoneInput"
                                   class="text-input"
                                   placeholder="XXXXXXXX"
                                   maxlength="8"
                                   style="flex: 1; padding: 10px 12px; font-size: 14px; border-radius: 0 8px 8px 0; direction: ltr; text-align: left; font-weight: 600; border: 2px solid #e5e7eb; min-width: 0;"
                                   value="">
                        </div>
                        <div id="phoneError" style="font-size: 11px; color: var(--danger); margin-top: 6px; display: none;">
                            <i class="fas fa-exclamation-circle" style="margin-left: 4px;"></i>
                            <span id="phoneErrorText">رقم الهاتف غير صحيح</span>
                        </div>
                    </div>
                    <div style="display: flex; gap: 8px;">
                        <button onclick="requestOTP()" id="sendOtpBtn" class="phone-action-btn primary" style="flex: 1;">
                            <i class="fas fa-paper-plane"></i>
                            إرسال الرمز
                        </button>
                        <button onclick="cancelPhoneEdit()" class="phone-action-btn secondary">
                            إلغاء
                        </button>
                    </div>
                </div>

                <!-- نموذج إدخال OTP -->
                <div id="otpForm" style="display: none; padding: 16px; border-radius: var(--radius); background: white; border: 1.5px solid rgba(16, 185, 129, 0.15);">
                    <div style="font-size: 14px; font-weight: 600; color: var(--dark); margin-bottom: 12px;">
                        <i class="fas fa-shield-alt" style="color: var(--secondary); margin-left: 6px;"></i>
                        التحقق من الرقم
                    </div>

                    <!-- عرض الرقم المدخل -->
                    <div style="background: rgba(16, 185, 129, 0.06); padding: 10px 12px; border-radius: 8px; margin-bottom: 12px; text-align: center;">
                        <span style="font-size: 11px; color: var(--gray);">الرقم الجديد: </span>
                        <span id="pendingPhoneDisplay" style="font-weight: 700; color: var(--dark); font-size: 14px; direction: ltr;">09XXXXXXXX</span>
                    </div>

                    <!-- حقول OTP -->
                    <div style="margin-bottom: 12px;">
                        <label style="font-size: 11px; color: var(--gray); margin-bottom: 8px; display: block; text-align: center;">
                            أدخل رمز التحقق (6 أرقام) - الرمز الافتراضي: 111111
                        </label>
                        <div class="otp-container">
                            <input type="text" class="otp-input" maxlength="1" data-index="0" inputmode="numeric" value="1">
                            <input type="text" class="otp-input" maxlength="1" data-index="1" inputmode="numeric" value="1">
                            <input type="text" class="otp-input" maxlength="1" data-index="2" inputmode="numeric" value="1">
                            <input type="text" class="otp-input" maxlength="1" data-index="3" inputmode="numeric" value="1">
                            <input type="text" class="otp-input" maxlength="1" data-index="4" inputmode="numeric" value="1">
                            <input type="text" class="otp-input" maxlength="1" data-index="5" inputmode="numeric" value="1">
                        </div>
                        <div id="otpError" style="margin-top: 8px; display: none; text-align: center;">
                            <span style="font-size: 11px; color: var(--danger);">
                                <i class="fas fa-exclamation-circle"></i>
                                رمز التحقق غير صحيح
                            </span>
                        </div>
                        <div id="otpTimer" style="font-size: 11px; color: var(--gray); margin-top: 8px; text-align: center;">
                            إعادة الإرسال خلال <span id="timerCount" style="font-weight: 700; color: var(--primary);">60</span> ثانية
                        </div>
                    </div>

                    <!-- أزرار -->
                    <div style="display: flex; gap: 8px;">
                        <button onclick="verifyOTP()" id="verifyOtpBtn" class="phone-action-btn primary" style="flex: 1;">
                            <i class="fas fa-check"></i>
                            تأكيد
                        </button>
                        <button onclick="resendOTP()" id="resendOtpBtn" class="phone-action-btn secondary" disabled>
                            إعادة
                        </button>
                        <button onclick="cancelPhoneEdit()" class="phone-action-btn secondary">
                            إلغاء
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- معلومات أكاديمية -->
        <div style="background: linear-gradient(135deg, rgba(79, 70, 229, 0.05), rgba(236, 72, 153, 0.05)); 
                    border-radius: var(--radius); padding: 20px; margin-top: 20px;">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 16px;">
                <div style="width: 36px; height: 36px; background: rgba(79, 70, 229, 0.1); 
                          border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-graduation-cap" style="color: var(--primary); font-size: 16px;"></i>
                </div>
                <div style="font-size: 15px; font-weight: 700; color: var(--dark);">المعلومات الأكاديمية</div>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px;">
                <div style="background: white; padding: 16px; border-radius: var(--radius-sm); text-align: center;">
                    <div style="font-size: 12px; color: var(--gray); margin-bottom: 8px;">المعدل التراكمي</div>
                    <div style="font-size: 24px; font-weight: 800; color: var(--primary);">3.75</div>
                    <div style="font-size: 11px; color: var(--secondary); margin-top: 4px;">
                        <i class="fas fa-arrow-up" style="margin-left: 4px;"></i>
                        ممتاز
                    </div>
                </div>
                
                <div style="background: white; padding: 16px; border-radius: var(--radius-sm); text-align: center;">
                    <div style="font-size: 12px; color: var(--gray); margin-bottom: 8px;">الساعات المنجزة</div>
                    <div style="font-size: 24px; font-weight: 800; color: var(--secondary);">98</div>
                    <div style="font-size: 11px; color: var(--gray); margin-top: 4px;">من أصل 160</div>
                </div>
            </div>
            
            <div style="margin-top: 16px;">
                <div style="font-size: 12px; color: var(--gray); margin-bottom: 8px;">التخصص</div>
                <div style="background: white; padding: 12px 16px; border-radius: var(--radius-sm); 
                          border-right: 4px solid var(--primary);">
                    <div style="font-size: 14px; font-weight: 700; color: var(--dark);">طب الأسنان</div>
                    <div style="font-size: 12px; color: var(--gray); margin-top: 4px;">
                        السنة الثالثة • الفصل الدراسي الثاني 2024
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- خط فاصل -->
    <div class="section-divider"></div>

    <!-- قسم تغيير كلمة المرور -->
    <div class="input-container" style="border-radius: var(--radius-lg); overflow: hidden;">
        <div class="section-title" style="padding-bottom: 16px; border-bottom: 2px solid rgba(245, 158, 11, 0.1);">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 36px; height: 36px; background: linear-gradient(135deg, rgba(245, 158, 11, 0.15), rgba(245, 158, 11, 0.05));
                          border-radius: 10px; display: flex; align-items: center; justify-content: center;
                          box-shadow: 0 2px 8px rgba(245, 158, 11, 0.15);">
                    <i class="fas fa-shield-alt" style="color: var(--warning); font-size: 16px;"></i>
                </div>
                <div>
                    <div style="font-size: 16px; font-weight: 700; color: var(--dark);">الأمان والحماية</div>
                    <div style="font-size: 12px; color: var(--gray);">تغيير كلمة المرور</div>
                </div>
            </div>
        </div>
        
        <form id="passwordChangeForm" onsubmit="return changePassword()" style="padding: 20px 0;">
            <!-- كلمة المرور الحالية -->
            <div style="margin-bottom: 20px;">
                <label style="display: flex; align-items: center; gap: 8px; font-size: 14px; font-weight: 600; color: var(--dark); margin-bottom: 10px;">
                    <div style="width: 30px; height: 30px; background: rgba(79, 70, 229, 0.1); 
                              border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-key" style="color: var(--primary); font-size: 14px;"></i>
                    </div>
                    كلمة المرور الحالية
                </label>
                <div style="position: relative;">
                    <input type="password" 
                           id="currentPassword"
                           class="modern-input" 
                           placeholder="أدخل كلمة المرور الحالية" 
                           required>
                    <button type="button" 
                            class="password-toggle"
                            onclick="togglePassword('currentPassword', this)">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
            
            <!-- كلمة المرور الجديدة -->
            <div style="margin-bottom: 20px;">
                <label style="display: flex; align-items: center; gap: 8px; font-size: 14px; font-weight: 600; color: var(--dark); margin-bottom: 10px;">
                    <div style="width: 30px; height: 30px; background: rgba(16, 185, 129, 0.1); 
                              border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-lock" style="color: var(--secondary); font-size: 14px;"></i>
                    </div>
                    كلمة المرور الجديدة
                    <span style="font-size: 11px; color: var(--gray); font-weight: normal; margin-right: auto;">
                        (8 خانات على الأقل)
                    </span>
                </label>
                <div style="position: relative;">
                    <input type="password" 
                           id="newPassword"
                           class="modern-input" 
                           placeholder="أدخل كلمة مرور جديدة" 
                           minlength="8"
                           required
                           pattern=".{8,}">
                    <button type="button" 
                            class="password-toggle"
                            onclick="togglePassword('newPassword', this)">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <div id="passwordStrength" style="margin-top: 12px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <span id="strengthText" style="font-size: 12px; font-weight: 600;">قوة كلمة المرور</span>
                        <span id="strengthPercentage" style="font-size: 12px; font-weight: 700;">0%</span>
                    </div>
                    <div style="height: 6px; background: var(--gray-light); border-radius: 3px; overflow: hidden; margin-bottom: 4px;">
                        <div id="strengthBar" style="width: 0%; height: 100%; transition: all 0.3s;"></div>
                    </div>
                    <div id="passwordRequirements" style="font-size: 11px; color: var(--gray);">
                        <i class="fas fa-info-circle" style="margin-left: 4px;"></i>
                        يجب أن تحتوي على 8 خانات على الأقل
                    </div>
                </div>
            </div>
            
            <!-- تأكيد كلمة المرور الجديدة -->
            <div style="margin-bottom: 24px;">
                <label style="display: flex; align-items: center; gap: 8px; font-size: 14px; font-weight: 600; color: var(--dark); margin-bottom: 10px;">
                    <div style="width: 30px; height: 30px; background: rgba(236, 72, 153, 0.1); 
                              border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-check-double" style="color: var(--accent); font-size: 14px;"></i>
                    </div>
                    تأكيد كلمة المرور الجديدة
                </label>
                <div style="position: relative;">
                    <input type="password" 
                           id="confirmPassword"
                           class="modern-input" 
                           placeholder="أعد إدخال كلمة المرور الجديدة" 
                           minlength="8"
                           required>
                    <button type="button" 
                            class="password-toggle"
                            onclick="togglePassword('confirmPassword', this)">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <div id="passwordMatch" style="margin-top: 8px; display: none;">
                    <div style="display: flex; align-items: center; gap: 6px; font-size: 12px; color: var(--secondary);">
                        <i class="fas fa-check-circle" style="font-size: 14px;"></i>
                        <span>كلمات المرور متطابقة</span>
                    </div>
                </div>
                <div id="passwordMismatch" style="margin-top: 8px; display: none;">
                    <div style="display: flex; align-items: center; gap: 6px; font-size: 12px; color: var(--danger);">
                        <i class="fas fa-exclamation-circle" style="font-size: 14px;"></i>
                        <span>كلمات المرور غير متطابقة</span>
                    </div>
                </div>
            </div>
            
            <!-- أزرار الإجراءات -->
            <div style="display: flex; gap: 12px;">
                <button type="submit"
                        class="modern-btn primary"
                        style="flex: 1; min-height: 52px;">
                    <i class="fas fa-save" style="margin-left: 8px;"></i>
                    حفظ
                </button>
                <button type="button"
                        class="modern-btn secondary"
                        onclick="resetPasswordForm()"
                        style="flex: 1; min-height: 52px;">
                    <i class="fas fa-redo" style="margin-left: 8px;"></i>
                    إعادة تعيين
                </button>
            </div>
        </form>
    </div>

    <!-- أزرار إضافية -->
    <div style="display: flex; flex-direction: column; gap: 12px; margin-top: 24px; margin-bottom: 32px;">
        <button class="modern-btn outline" onclick="showAcademicRecord()">
            <i class="fas fa-scroll" style="margin-left: 10px;"></i>
            <div style="flex: 1; text-align: right;">السجل الأكاديمي الكامل</div>
            <i class="fas fa-chevron-left" style="font-size: 12px;"></i>
        </button>
        
        <button class="modern-btn outline" onclick="editProfileDetails()">
            <i class="fas fa-user-edit" style="margin-left: 10px;"></i>
            <div style="flex: 1; text-align: right;">تعديل معلومات الملف الشخصي</div>
            <i class="fas fa-chevron-left" style="font-size: 12px;"></i>
        </button>
        
        <button class="modern-btn outline danger" onclick="showLogoutModalWithBlur()">
            <i class="fas fa-sign-out-alt" style="margin-left: 10px;"></i>
            <div style="flex: 1; text-align: right;">تسجيل الخروج</div>
            <i class="fas fa-chevron-left" style="font-size: 12px;"></i>
        </button>
    </div>
</div>

<!-- أنماط إضافية محسنة -->
<style>
/* Profile Page Enhanced Styles */
.profile-container {
    animation: fadeInUp 0.5s ease;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Survey Cards Enhancement */
.survey-card {
    background: #fff !important;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
}

.survey-card:hover {
    transform: translateY(-6px) !important;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1) !important;
}

.survey-card:active {
    transform: scale(0.97) !important;
}

/* Info Cards Animation */
.info-card {
    transition: all 0.3s ease;
}

.info-card:hover {
    transform: translateX(-4px);
}

/* Button Hover States */
.modern-btn.outline {
    position: relative;
    overflow: hidden;
}

.modern-btn.outline::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(79, 70, 229, 0.05), transparent);
    transition: left 0.5s;
}

.modern-btn.outline:hover::before {
    left: 100%;
}

/* Password Strength Indicator Animation */
#strengthBar {
    transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1), background 0.3s;
}

/* OTP Input Focus Animation */
.otp-input:focus {
    transform: scale(1.05);
}

/* Academic Info Cards */
.profile-container [style*="grid-template-columns: repeat(2, 1fr)"] > div {
    transition: all 0.3s ease;
}

.profile-container [style*="grid-template-columns: repeat(2, 1fr)"] > div:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
}

/* Surveys Cards Container */
.surveys-cards {
    padding: 12px 4px 16px !important;
}

/* Enhanced Input Focus */
.modern-input {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.modern-input:focus {
    transform: translateY(-1px);
}

/* Profile Header Animation */
.profile-header {
    position: relative;
}

.profile-header::before {
    content: '';
    position: absolute;
    top: -100px;
    left: 50%;
    transform: translateX(-50%);
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(79, 70, 229, 0.08) 0%, transparent 70%);
    pointer-events: none;
    z-index: -1;
}

/* Shake Animation for Errors */
@keyframes shake {
    0%, 100% { transform: translateX(0); }
    10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
    20%, 40%, 60%, 80% { transform: translateX(5px); }
}

.shake {
    animation: shake 0.5s ease;
}
</style>

<script>
// تفعيل الصفحة عند التحميل
document.addEventListener('DOMContentLoaded', function() {
    initPasswordInputs();
    initPhoneNumberEditor();
    
    // إضافة تأثير عند تحميل الصفحة
    setTimeout(() => {
        document.querySelector('.profile-header').style.animation = 'fadeInUp 0.8s ease';
    }, 100);
});

// === إدارة رقم الهاتف ===
let isEditingPhone = false;
let originalPhoneNumber = "12345678";
let phoneChangesRemaining = 3;
let otpTimerInterval = null;
let pendingPhoneNumber = "";

function initPhoneNumberEditor() {
    // تحميل عدد التغييرات المتبقية من localStorage
    const savedChanges = localStorage.getItem('phoneChangesRemaining');
    if (savedChanges !== null) {
        phoneChangesRemaining = parseInt(savedChanges);
        updateChangesCounter();
    }

    const phoneInput = document.getElementById('newPhoneInput');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            // فقط الأرقام (بدون مسافات)
            let value = e.target.value.replace(/\D/g, '');

            // تحديد الطول بـ 8 أرقام
            if (value.length > 8) {
                value = value.substring(0, 8);
            }

            e.target.value = value;
            validatePhoneNumber(value);
        });
    }

    // تهيئة حقول OTP
    initOTPInputs();
}

function initOTPInputs() {
    const otpInputs = document.querySelectorAll('.otp-input');
    otpInputs.forEach((input, index) => {
        input.addEventListener('input', function(e) {
            const value = e.target.value.replace(/\D/g, '');
            e.target.value = value;

            if (value) {
                input.classList.add('filled');
                if (index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }
            } else {
                input.classList.remove('filled');
            }

            // تحقق من اكتمال الـ OTP
            checkOTPComplete();
        });

        input.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace') {
                if (!e.target.value && index > 0) {
                    otpInputs[index - 1].focus();
                    otpInputs[index - 1].value = '';
                    otpInputs[index - 1].classList.remove('filled');
                }
            }
        });

        input.addEventListener('focus', function() {
            this.select();
        });

        input.addEventListener('paste', function(e) {
            e.preventDefault();
            const pastedData = e.clipboardData.getData('text').replace(/\D/g, '');
            if (pastedData.length >= 6) {
                otpInputs.forEach((inp, i) => {
                    if (i < 6) {
                        inp.value = pastedData[i] || '';
                        if (inp.value) inp.classList.add('filled');
                    }
                });
                checkOTPComplete();
                otpInputs[5].focus();
            }
        });
    });
}

function checkOTPComplete() {
    const otpInputs = document.querySelectorAll('.otp-input');
    let isComplete = true;
    otpInputs.forEach(input => {
        if (!input.value) isComplete = false;
        input.classList.toggle('filled', !!input.value);
    });
    return isComplete;
}

function updateChangesCounter() {
    const counter = document.getElementById('phoneChangesLeft');
    if (counter) {
        if (phoneChangesRemaining === 0) {
            counter.style.background = 'rgba(239, 68, 68, 0.1)';
            counter.style.color = 'var(--danger)';
            counter.textContent = 'لا يمكن التغيير';
        } else {
            counter.textContent = phoneChangesRemaining + ' تغييرات متبقية';
        }
    }
}

function editPhoneNumber() {
    if (phoneChangesRemaining === 0) {
        showToast('لقد استنفذت جميع محاولات تغيير الرقم', 'warning');
        return;
    }

    if (!isEditingPhone) {
        isEditingPhone = true;

        // إخفاء بطاقة العرض وإظهار نموذج التعديل
        document.getElementById('phoneDisplayCard').style.display = 'none';
        document.getElementById('phoneEditForm').style.display = 'block';
        document.getElementById('otpForm').style.display = 'none';

        // إعادة تعيين الحقل
        document.getElementById('newPhoneInput').value = '';
        document.getElementById('phoneError').style.display = 'none';

        // التركيز على حقل الإدخال
        setTimeout(() => {
            document.getElementById('newPhoneInput').focus();
        }, 100);
    }
}

function cancelPhoneEdit() {
    isEditingPhone = false;

    // إظهار بطاقة العرض وإخفاء النماذج
    document.getElementById('phoneDisplayCard').style.display = 'flex';
    document.getElementById('phoneEditForm').style.display = 'none';
    document.getElementById('otpForm').style.display = 'none';

    // إيقاف المؤقت
    if (otpTimerInterval) {
        clearInterval(otpTimerInterval);
        otpTimerInterval = null;
    }

    // إعادة تعيين حقول OTP
    document.querySelectorAll('.otp-input').forEach(input => {
        input.value = '';
        input.classList.remove('filled', 'error');
    });

    // إعادة تعيين المؤقت
    document.getElementById('otpTimer').innerHTML = 'إعادة الإرسال خلال <span id="timerCount" style="font-weight: 700; color: var(--primary);">60</span> ثانية';
}

function validatePhoneNumber(phone) {
    const phoneError = document.getElementById('phoneError');
    const phoneErrorText = document.getElementById('phoneErrorText');

    if (phone.length === 0) {
        phoneError.style.display = 'none';
        return false;
    }

    if (phone.length !== 8) {
        phoneError.style.display = 'block';
        phoneErrorText.textContent = 'يجب أن يتكون الرقم من 8 أرقام';
        return false;
    }

    phoneError.style.display = 'none';
    return true;
}

function requestOTP() {
    const phoneInput = document.getElementById('newPhoneInput');
    const newPhone = phoneInput.value.trim();

    if (!validatePhoneNumber(newPhone)) {
        // تأثير اهتزاز
        const phoneCard = document.getElementById('phoneCard');
        phoneCard.classList.add('shake');
        setTimeout(() => phoneCard.classList.remove('shake'), 500);
        return;
    }

    pendingPhoneNumber = newPhone;

    // إظهار التحميل
    showLoading();

    setTimeout(() => {
        hideLoading();

        // تحديث عرض الرقم المعلق
        const formattedPhone = '09' + newPhone;
        document.getElementById('pendingPhoneDisplay').textContent = formattedPhone;

        // إخفاء نموذج الرقم وإظهار نموذج OTP
        document.getElementById('phoneEditForm').style.display = 'none';
        document.getElementById('otpForm').style.display = 'block';

        // إعادة تعيين حقول OTP
        document.querySelectorAll('.otp-input').forEach(input => {
            input.value = '';
            input.classList.remove('filled', 'error');
        });

        // بدء المؤقت
        startOTPTimer();

        showToast('تم إرسال رمز التحقق', 'success');

        // التركيز على أول حقل OTP
        setTimeout(() => {
            document.querySelector('.otp-input').focus();
        }, 100);
    }, 1500);
}

function startOTPTimer() {
    let seconds = 60;
    const timerDisplay = document.getElementById('timerCount');
    const resendBtn = document.getElementById('resendOtpBtn');

    resendBtn.disabled = true;

    otpTimerInterval = setInterval(() => {
        seconds--;
        timerDisplay.textContent = seconds;

        if (seconds <= 0) {
            clearInterval(otpTimerInterval);
            otpTimerInterval = null;
            resendBtn.disabled = false;
            document.getElementById('otpTimer').innerHTML = '<span style="color: var(--primary); cursor: pointer;" onclick="resendOTP()">إعادة إرسال الرمز</span>';
        }
    }, 1000);
}

function resendOTP() {
    showLoading();

    setTimeout(() => {
        hideLoading();

        // إعادة تعيين حقول OTP
        document.querySelectorAll('.otp-input').forEach(input => {
            input.value = '';
            input.classList.remove('filled', 'error');
        });

        // إعادة المؤقت
        document.getElementById('otpTimer').innerHTML = 'إعادة الإرسال خلال <span id="timerCount">60</span> ثانية';
        startOTPTimer();

        showToast('تم إعادة إرسال رمز التحقق', 'info');
        document.querySelector('.otp-input').focus();
    }, 1000);
}

function verifyOTP() {
    const otpInputs = document.querySelectorAll('.otp-input');
    let otp = '';
    otpInputs.forEach(input => otp += input.value);

    if (otp.length !== 6) {
        otpInputs.forEach(input => input.classList.add('error'));
        document.getElementById('otpError').style.display = 'block';
        setTimeout(() => {
            otpInputs.forEach(input => input.classList.remove('error'));
        }, 500);
        return;
    }

    showLoading();

    // محاكاة التحقق من OTP (في الواقع يجب التحقق من الخادم)
    setTimeout(() => {
        hideLoading();

        // نجاح التحقق
        const fullNumber = '09' + pendingPhoneNumber;
        originalPhoneNumber = pendingPhoneNumber;
        document.getElementById('phoneDisplay').textContent = fullNumber;

        // إضافة إشعار للتبديل الناجح
        addPhoneChangeNotification(fullNumber);

        // تقليل عدد التغييرات المتبقية
        phoneChangesRemaining--;
        localStorage.setItem('phoneChangesRemaining', phoneChangesRemaining);
        updateChangesCounter();

        // العودة للعرض العادي
        cancelPhoneEdit();

        // إظهار إشعار Toast متل السجل الأكاديمي
        showToast('تم تغيير رقم الهاتف بنجاح إلى ' + fullNumber, 'success');

        // إظهار رسالة نجاح
        showSuccessModal(`
            <div style="text-align: center;">
                <div style="width: 70px; height: 70px; background: linear-gradient(135deg, var(--secondary), #059669); color: white;
                          border-radius: 50%; display: flex; align-items: center; justify-content: center;
                          margin: 0 auto 20px; font-size: 28px; box-shadow: 0 8px 24px rgba(16, 185, 129, 0.3);">
                    <i class="fas fa-check"></i>
                </div>
                <h3 style="font-size: 20px; color: var(--dark); margin-bottom: 10px; font-weight: 700;">تم تحديث رقم الهاتف</h3>
                <p style="color: var(--gray); font-size: 14px; margin-bottom: 16px;">
                    تم تحديث رقم هاتفك بنجاح
                </p>
                <div style="background: var(--gray-light); padding: 14px 20px; border-radius: var(--radius);
                          font-family: 'Tajawal', sans-serif; font-weight: 700; color: var(--dark); font-size: 16px; direction: ltr;">
                    ${fullNumber}
                </div>
                <div style="margin-top: 16px; font-size: 12px; color: var(--warning); background: rgba(245, 158, 11, 0.1); padding: 10px; border-radius: 8px;">
                    <i class="fas fa-info-circle" style="margin-left: 6px;"></i>
                    متبقي لك ${phoneChangesRemaining} ${phoneChangesRemaining === 1 ? 'تغيير' : 'تغييرات'}
                </div>
            </div>
        `);
    }, 1500);
}

// === إدارة كلمة المرور ===
function initPasswordInputs() {
    const newPasswordInput = document.getElementById('newPassword');
    const confirmPasswordInput = document.getElementById('confirmPassword');
    
    if (newPasswordInput) {
        newPasswordInput.addEventListener('input', function() {
            updatePasswordStrength(this.value);
            checkPasswordMatch();
        });
    }
    
    if (confirmPasswordInput) {
        confirmPasswordInput.addEventListener('input', checkPasswordMatch);
    }
}

function updatePasswordStrength(password) {
    const strengthBar = document.getElementById('strengthBar');
    const strengthText = document.getElementById('strengthText');
    const strengthPercentage = document.getElementById('strengthPercentage');
    
    let strength = 0;
    let text = 'ضعيفة جداً';
    let level = 0;
    
    // التحقق من الطول
    if (password.length >= 8) strength += 25;
    if (password.length >= 12) strength += 10;
    
    // التحقق من الأحرف الصغيرة
    if (/[a-z]/.test(password)) strength += 25;
    
    // التحقق من الأحرف الكبيرة
    if (/[A-Z]/.test(password)) strength += 25;
    
    // التحقق من الأرقام والرموز
    if (/[0-9]/.test(password)) strength += 15;
    if (/[^A-Za-z0-9]/.test(password)) strength += 10;
    
    strength = Math.min(strength, 100);
    
    // تحديد المستوى والنص
    if (strength <= 25) {
        text = 'ضعيفة جداً';
        level = 0;
    } else if (strength <= 50) {
        text = 'ضعيفة';
        level = 1;
    } else if (strength <= 75) {
        text = 'جيدة';
        level = 2;
    } else if (strength <= 90) {
        text = 'قوية';
        level = 3;
    } else {
        text = 'قوية جداً';
        level = 4;
    }
    
    // التحديث المرئي
    strengthBar.className = `strength-${level}`;
    strengthBar.style.width = `${strength}%`;
    strengthText.textContent = text;
    strengthPercentage.textContent = `${strength}%`;
    
    // تحديث لون النسبة
    strengthPercentage.style.color = getStrengthColor(level);
}

function getStrengthColor(level) {
    switch(level) {
        case 0: return 'var(--danger)';
        case 1: return 'var(--danger)';
        case 2: return 'var(--warning)';
        case 3: return 'var(--secondary)';
        case 4: return 'var(--primary)';
        default: return 'var(--gray)';
    }
}

function checkPasswordMatch() {
    const newPassword = document.getElementById('newPassword').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    const matchDiv = document.getElementById('passwordMatch');
    const mismatchDiv = document.getElementById('passwordMismatch');
    
    if (!newPassword || !confirmPassword) {
        matchDiv.style.display = 'none';
        mismatchDiv.style.display = 'none';
        return;
    }
    
    if (newPassword === confirmPassword && newPassword.length >= 8) {
        matchDiv.style.display = 'flex';
        mismatchDiv.style.display = 'none';
    } else {
        matchDiv.style.display = 'none';
        mismatchDiv.style.display = 'flex';
    }
}

// === وظائف مشتركة ===
function togglePassword(inputId, button) {
    const input = document.getElementById(inputId);
    const icon = button.querySelector('i');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'fas fa-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'fas fa-eye';
    }
}

function changePassword() {
    event.preventDefault();

    const currentPassword = document.getElementById('currentPassword').value;
    const newPassword = document.getElementById('newPassword').value;
    const confirmPassword = document.getElementById('confirmPassword').value;

    if (!currentPassword || !newPassword || !confirmPassword) {
        showToast('يرجى ملء جميع الحقول', 'warning');
        return false;
    }

    if (newPassword.length < 8) {
        showToast('كلمة المرور يجب أن تكون 8 خانات على الأقل', 'warning');
        return false;
    }

    if (newPassword !== confirmPassword) {
        showToast('كلمات المرور غير متطابقة', 'warning');
        return false;
    }

    showLoading();

    fetch('/api/profile/password', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({
            current_password: currentPassword,
            password: newPassword,
            password_confirmation: confirmPassword,
        }),
    })
    .then(r => r.json())
    .then(data => {
        hideLoading();
        if (data.success) {
            showSuccessModal(`
                <div style="text-align: center;">
                    <div style="width: 60px; height: 60px; background: var(--secondary); color: white;
                              border-radius: 50%; display: flex; align-items: center; justify-content: center;
                              margin: 0 auto 16px; font-size: 24px;">
                        <i class="fas fa-check"></i>
                    </div>
                    <h3 style="font-size: 18px; color: var(--dark); margin-bottom: 8px;">تم تغيير كلمة المرور</h3>
                    <p style="color: var(--gray); font-size: 14px;">تم تحديث كلمة المرور بنجاح.</p>
                </div>
            `);
            resetPasswordForm();
        } else {
            showToast(data.message || 'حدث خطأ في تغيير كلمة المرور', 'error');
        }
    })
    .catch(() => {
        hideLoading();
        showToast('حدث خطأ في الاتصال', 'error');
    });

    return false;
}

function resetPasswordForm() {
    document.getElementById('passwordChangeForm').reset();
    updatePasswordStrength('');
    checkPasswordMatch();
    showToast('تم إعادة تعيين النموذج', 'info');
}

// === وظائف أخرى ===
function editContactInfo() {
    showToast('جاري فتح إعدادات التواصل...', 'info');
    // هنا يمكن فتح نافذة تعديل كاملة
}

function editProfileDetails() {
    showToast('جاري فتح صفحة تعديل الملف الشخصي...', 'info');
}

function showAcademicRecord() {
    showToast('جاري تحميل السجل الأكاديمي...', 'info');
}

function openSurveys() {
    showModal(`
        <div>
            <h3 style="font-size: 18px; color: var(--dark); margin-bottom: 16px; text-align: center;">الاستبيانات</h3>
            <p style="color: var(--gray); font-size: 14px; margin-bottom: 24px; text-align: center;">
                اختر الاستبيان الذي ترغب في المشاركة به
            </p>
            
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <button class="modern-btn outline" style="justify-content: flex-start; padding: 16px;">
                    <i class="fas fa-clipboard-check" style="margin-left: 12px; color: var(--primary);"></i>
                    <div style="flex: 1; text-align: right;">
                        <div style="font-weight: 700; color: var(--dark);">استبيان رضا الطلاب</div>
                        <div style="font-size: 12px; color: var(--gray);">مدة: 10 دقائق</div>
                    </div>
                    <div style="background: var(--primary); color: white; padding: 4px 12px; border-radius: 12px; font-size: 12px;">
                        جديد
                    </div>
                </button>
                
                <button class="modern-btn outline" style="justify-content: flex-start; padding: 16px;">
                    <i class="fas fa-star" style="margin-left: 12px; color: var(--warning);"></i>
                    <div style="flex: 1; text-align: right;">
                        <div style="font-weight: 700; color: var(--dark);">تقييم المقررات الدراسية</div>
                        <div style="font-size: 12px; color: var(--gray);">مدة: 15 دقائق</div>
                    </div>
                    <div style="background: var(--warning); color: white; padding: 4px 12px; border-radius: 12px; font-size: 12px;">
                        جديد
                    </div>
                </button>
            </div>
            
            <div style="margin-top: 24px;">
                <button onclick="closeModal()" 
                        style="background: var(--gray-light); color: var(--gray-dark); border: none; 
                               padding: 12px; border-radius: var(--radius); font-weight: 600; cursor: pointer; width: 100%;">
                    إغلاق
                </button>
            </div>
        </div>
    `, 'الاستبيانات المتاحة');
}

function openComplaints() {
    showModal(`
        <div>
            <h3 style="font-size: 18px; color: var(--dark); margin-bottom: 16px; text-align: center;">الشكاوى والاقتراحات</h3>
            
            <div style="margin-bottom: 20px;">
                <textarea class="modern-input" placeholder="اكتب شكواك أو اقتراحك هنا..." rows="5" 
                          style="width: 100%; resize: vertical; min-height: 120px;"></textarea>
            </div>
            
            <div style="display: flex; gap: 12px;">
                <button onclick="submitComplaint()" 
                        style="flex: 1; background: var(--primary); color: white; border: none; 
                               padding: 14px; border-radius: var(--radius); font-weight: 600; cursor: pointer;">
                    <i class="fas fa-paper-plane" style="margin-left: 8px;"></i>
                    إرسال
                </button>
                <button onclick="closeModal()" 
                        style="flex: 1; background: white; color: var(--gray-dark); border: 2px solid #e5e7eb; 
                               padding: 14px; border-radius: var(--radius); font-weight: 600; cursor: pointer;">
                    إلغاء
                </button>
            </div>
        </div>
    `, 'إرسال شكوى');
}

// === وظائف المساعدة ===
function showModal(content, title = '') {
    const modal = document.createElement('div');
    modal.className = 'modal';
    modal.innerHTML = `
        <div style="position: fixed; top: 0; right: 0; bottom: 0; left: 0; background: rgba(0,0,0,0.5);
                    backdrop-filter: blur(8px); z-index: 2000; display: flex; align-items: center;
                    justify-content: center; padding: 20px; animation: fadeIn 0.3s ease;">
            <div style="background: white; border-radius: var(--radius-lg); padding: 24px; width: 90%;
                        max-width: 400px; animation: scaleIn 0.3s ease; max-height: 80vh; overflow-y: auto;">
                ${title ? `<div style="font-size: 18px; font-weight: 700; color: var(--dark); margin-bottom: 16px; text-align: center;">${title}</div>` : ''}
                ${content}
            </div>
        </div>
    `;
    document.body.appendChild(modal);

    // إغلاق عند النقر خارج المحتوى
    modal.querySelector('div').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });
}

function showSuccessModal(content) {
    const modal = document.createElement('div');
    modal.className = 'modal';
    modal.innerHTML = `
        <div style="position: fixed; top: 0; right: 0; bottom: 0; left: 0; background: rgba(0,0,0,0.5); 
                    backdrop-filter: blur(8px); z-index: 2000; display: flex; align-items: center; 
                    justify-content: center; padding: 20px; animation: fadeIn 0.3s ease;">
            <div style="background: white; border-radius: var(--radius-lg); padding: 30px; width: 90%; 
                        max-width: 350px; animation: scaleIn 0.3s ease;">
                ${content}
                <div style="margin-top: 24px; text-align: center;">
                    <button onclick="closeModal()" 
                            style="background: var(--primary); color: white; border: none; 
                                   padding: 12px 32px; border-radius: var(--radius); font-weight: 600; cursor: pointer;">
                        موافق
                    </button>
                </div>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
}

// ... باقي وظائف المساعدة من الكود السابق (showLoading, hideLoading, showToast, closeModal)
// يتم الحفاظ على نفس وظائف المساعدة من الإصدار السابق
</script>

<script>
// وظائف المساعدة الأساسية - موحدة مع الصفحة الرئيسية
function showLoading() {
    // استخدام الـ overlay الموجود في الـ layout
    const pageOverlay = document.getElementById('pageLoadingOverlay');
    if (pageOverlay) {
        pageOverlay.classList.add('active');
        return;
    }

    // إنشاء overlay جديد بنفس التصميم
    const loading = document.createElement('div');
    loading.id = 'loadingOverlay';
    loading.innerHTML = `
        <div style="position: fixed; top: 0; right: 0; bottom: 0; left: 0; background: rgba(255,255,255,0.7);
                    backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
                    z-index: 10000; display: flex; align-items: center; justify-content: center;">
            <div style="text-align: center; background: white; padding: 32px 48px; border-radius: 16px;
                       box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15); border: 1px solid rgba(229, 231, 235, 0.5);">
                <div style="width: 50px; height: 50px; border: 4px solid rgba(79, 70, 229, 0.15);
                          border-top-color: var(--primary); border-radius: 50%; animation: spin 0.8s linear infinite;
                          margin: 0 auto 16px;"></div>
                <div style="color: var(--primary); font-size: 14px; font-weight: 600;">جاري المعالجة...</div>
                <div style="color: var(--gray); font-size: 12px; margin-top: 6px;">يرجى الانتظار</div>
            </div>
        </div>
    `;
    document.body.appendChild(loading);
}

function hideLoading() {
    // إخفاء الـ overlay الموجود في الـ layout
    const pageOverlay = document.getElementById('pageLoadingOverlay');
    if (pageOverlay) {
        pageOverlay.classList.remove('active');
    }

    // إزالة الـ overlay المؤقت إن وجد
    const loading = document.getElementById('loadingOverlay');
    if (loading) loading.remove();
}

function showToast(message, type = 'info') {
    const colors = {
        info: { bg: 'var(--primary)', icon: 'fa-info-circle' },
        warning: { bg: 'var(--warning)', icon: 'fa-exclamation-triangle' },
        success: { bg: 'var(--secondary)', icon: 'fa-check-circle' }
    };
    
    const color = colors[type] || colors.info;
    const toast = document.createElement('div');
    
    toast.innerHTML = `
        <div style="position: fixed; top: 80px; right: 16px; left: 16px; background: ${color.bg}; 
                   color: white; padding: 14px 20px; border-radius: var(--radius); z-index: 1000; 
                   text-align: center; font-weight: 600; animation: slideDown 0.3s ease;
                   display: flex; align-items: center; justify-content: center; gap: 10px; box-shadow: var(--shadow);">
            <i class="fas ${color.icon}" style="font-size: 16px;"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.animation = 'slideUp 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

function closeModal() {
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        modal.style.animation = 'fadeOut 0.3s ease';
        setTimeout(() => modal.remove(), 300);
    });
}

// إشعار عائم فخم
function showFloatingNotification(message, type = 'success', details = '') {
    const colors = {
        success: { bg: 'linear-gradient(135deg, #10b981, #059669)', icon: 'fa-check-circle' },
        error: { bg: 'linear-gradient(135deg, #ef4444, #dc2626)', icon: 'fa-times-circle' },
        info: { bg: 'linear-gradient(135deg, #4f46e5, #6366f1)', icon: 'fa-info-circle' },
        warning: { bg: 'linear-gradient(135deg, #f59e0b, #d97706)', icon: 'fa-exclamation-triangle' }
    };

    const color = colors[type] || colors.success;

    const notification = document.createElement('div');
    notification.className = 'floating-notification';
    notification.innerHTML = `
        <div style="position: fixed; top: 20px; right: 16px; left: 16px; z-index: 10000;
                    background: ${color.bg}; color: white; padding: 16px 20px;
                    border-radius: 16px; box-shadow: 0 10px 40px rgba(0,0,0,0.2);
                    animation: floatIn 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
                    backdrop-filter: blur(10px);">
            <div style="display: flex; align-items: center; gap: 14px;">
                <div style="width: 44px; height: 44px; background: rgba(255,255,255,0.2);
                          border-radius: 12px; display: flex; align-items: center; justify-content: center;
                          flex-shrink: 0;">
                    <i class="fas ${color.icon}" style="font-size: 20px;"></i>
                </div>
                <div style="flex: 1;">
                    <div style="font-size: 15px; font-weight: 700; margin-bottom: 2px;">${message}</div>
                    ${details ? `<div style="font-size: 13px; opacity: 0.9; direction: ltr;">${details}</div>` : ''}
                </div>
                <button onclick="this.closest('.floating-notification').remove()"
                        style="background: rgba(255,255,255,0.2); border: none; color: white;
                               width: 28px; height: 28px; border-radius: 8px; cursor: pointer;
                               display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-times" style="font-size: 12px;"></i>
                </button>
            </div>
        </div>
    `;
    document.body.appendChild(notification);

    // إزالة تلقائية بعد 5 ثواني
    setTimeout(() => {
        if (notification.parentNode) {
            notification.style.animation = 'floatOut 0.4s ease forwards';
            setTimeout(() => notification.remove(), 400);
        }
    }, 5000);
}

// إضافة أنيميشن إذا لم تكن موجودة
if (!document.querySelector('style[data-profile-animations]')) {
    const style = document.createElement('style');
    style.setAttribute('data-profile-animations', 'true');
    style.textContent = `
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes slideUp {
            from {
                opacity: 1;
                transform: translateY(0);
            }
            to {
                opacity: 0;
                transform: translateY(-30px);
            }
        }

        @keyframes floatIn {
            from {
                opacity: 0;
                transform: translateY(-100px) scale(0.8);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes floatOut {
            from {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
            to {
                opacity: 0;
                transform: translateY(-50px) scale(0.9);
            }
        }
    `;
    document.head.appendChild(style);
}

// === Logout with Blur Effect ===
function showLogoutModalWithBlur() {
    // Use the layout's showLogoutModal function
    if (typeof showLogoutModal === 'function') {
        showLogoutModal();
    }
}

// === وظائف إضافية للاستطلاعات والتقارير ===
function openReports() {
    showModal(`
        <div>
            <h3 style="font-size: 18px; color: var(--dark); margin-bottom: 16px; text-align: center;">التقارير</h3>
            <p style="color: var(--gray); font-size: 14px; margin-bottom: 24px; text-align: center;">
                عرض تقاريرك الأكاديمية
            </p>

            <div style="display: flex; flex-direction: column; gap: 12px;">
                <button class="modern-btn outline" style="justify-content: flex-start; padding: 16px;">
                    <i class="fas fa-chart-line" style="margin-left: 12px; color: var(--primary);"></i>
                    <div style="flex: 1; text-align: right;">
                        <div style="font-weight: 700; color: var(--dark);">تقرير الأداء الأكاديمي</div>
                        <div style="font-size: 12px; color: var(--gray);">آخر تحديث: اليوم</div>
                    </div>
                </button>

                <button class="modern-btn outline" style="justify-content: flex-start; padding: 16px;">
                    <i class="fas fa-calendar-check" style="margin-left: 12px; color: var(--secondary);"></i>
                    <div style="flex: 1; text-align: right;">
                        <div style="font-weight: 700; color: var(--dark);">تقرير الحضور</div>
                        <div style="font-size: 12px; color: var(--gray);">آخر تحديث: أمس</div>
                    </div>
                </button>
            </div>

            <div style="margin-top: 24px;">
                <button onclick="closeModal()"
                        style="background: var(--gray-light); color: var(--gray-dark); border: none;
                               padding: 12px; border-radius: var(--radius); font-weight: 600; cursor: pointer; width: 100%;">
                    إغلاق
                </button>
            </div>
        </div>
    `, 'التقارير');
}

function openSuggestions() {
    showModal(`
        <div>
            <h3 style="font-size: 18px; color: var(--dark); margin-bottom: 16px; text-align: center;">الاقتراحات</h3>

            <div style="margin-bottom: 20px;">
                <label style="font-size: 13px; color: var(--gray-dark); margin-bottom: 8px; display: block; font-weight: 600;">
                    شارك اقتراحك لتحسين النظام
                </label>
                <textarea class="modern-input" placeholder="اكتب اقتراحك هنا..." rows="5"
                          style="width: 100%; resize: vertical; min-height: 120px; padding-left: 16px;"></textarea>
            </div>

            <div style="display: flex; gap: 12px;">
                <button onclick="submitSuggestion()"
                        style="flex: 1; background: linear-gradient(135deg, var(--accent), #be185d); color: white; border: none;
                               padding: 14px; border-radius: var(--radius); font-weight: 600; cursor: pointer;
                               box-shadow: 0 4px 12px rgba(236, 72, 153, 0.25);">
                    <i class="fas fa-paper-plane" style="margin-left: 8px;"></i>
                    إرسال
                </button>
                <button onclick="closeModal()"
                        style="flex: 1; background: white; color: var(--gray-dark); border: 2px solid #e5e7eb;
                               padding: 14px; border-radius: var(--radius); font-weight: 600; cursor: pointer;">
                    إلغاء
                </button>
            </div>
        </div>
    `, 'إرسال اقتراح');
}

function submitSuggestion() {
    showLoading();
    setTimeout(() => {
        hideLoading();
        closeModal();
        showToast('تم إرسال اقتراحك بنجاح، شكراً لك!', 'success');
    }, 1000);
}

function submitComplaint() {
    showLoading();
    setTimeout(() => {
        hideLoading();
        closeModal();
        showToast('تم إرسال شكواك بنجاح، سيتم مراجعتها قريباً', 'success');
    }, 1000);
}

// === وظيفة إضافة إشعار تغيير الرقم ===
function addPhoneChangeNotification(newPhone) {
    // إضافة إشعار جديد في localStorage
    const notifications = JSON.parse(localStorage.getItem('profileNotifications') || '[]');
    const newNotification = {
        id: Date.now(),
        type: 'phone_change',
        title: 'تم تغيير رقم الهاتف',
        message: `تم تغيير رقم هاتفك بنجاح إلى ${newPhone}`,
        time: new Date().toISOString(),
        read: false
    };
    notifications.unshift(newNotification);
    localStorage.setItem('profileNotifications', JSON.stringify(notifications));

    // تحديث badge الإشعارات
    const badge = document.getElementById('notificationBadge');
    if (badge) {
        const currentCount = parseInt(badge.getAttribute('data-count') || '0');
        badge.setAttribute('data-count', currentCount + 1);
        badge.textContent = (currentCount + 1).toString();
        badge.classList.remove('hidden');
    }
}
</script>
@endsection
