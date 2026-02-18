#!/bin/bash

# ================================================================================
# Multaqa Dental Platform - Termux Setup Script
# سكريبت إعداد منصة ملتقى على Termux
# ================================================================================

set -e  # Exit on error

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
CYAN='\033[0;36m'
NC='\033[0m' # No Color

# ================================================================================
# Helper Functions
# ================================================================================

print_banner() {
    clear
    echo -e "${CYAN}"
    echo "╔══════════════════════════════════════════════════════════════╗"
    echo "║                                                              ║"
    echo "║           🦷  منصة ملتقى - نظام إدارة عيادة الأسنان          ║"
    echo "║           Multaqa Dental Platform Setup                      ║"
    echo "║                                                              ║"
    echo "╚══════════════════════════════════════════════════════════════╝"
    echo -e "${NC}"
    echo ""
}

print_status() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

print_success() {
    echo -e "${GREEN}[✓]${NC} $1"
}

print_error() {
    echo -e "${RED}[✗]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[!]${NC} $1"
}

print_step() {
    echo ""
    echo -e "${CYAN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
    echo -e "${CYAN}  $1${NC}"
    echo -e "${CYAN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
    echo ""
}

# ================================================================================
# Check Termux Environment
# ================================================================================

check_termux() {
    print_step "التحقق من بيئة Termux"
    
    if [ -z "$TERMUX_VERSION" ] && [ ! -d "/data/data/com.termux" ]; then
        print_error "هذا السكريبت مصمم للعمل على Termux فقط!"
        exit 1
    fi
    
    print_success "بيئة Termux تم التحقق منها"
}

# ================================================================================
# Update Packages
# ================================================================================

update_packages() {
    print_step "تحديث الحزم"
    
    print_status "تحديث قائمة الحزم..."
    apt update -y
    
    print_status "ترقية الحزم..."
    apt upgrade -y
    
    print_success "تم تحديث الحزم بنجاح"
}

# ================================================================================
# Install Required Packages
# ================================================================================

install_packages() {
    print_step "تثبيت الحزم المطلوبة"
    
    PACKAGES="git php php-fpm php-sqlite php-pgsql php-mysql php-curl php-mbstring php-openssl php-json php-xml php-zip php-tokenizer php-fileinfo composer nodejs sqlite"
    
    for pkg in $PACKAGES; do
        print_status "تثبيت: $pkg"
        apt install -y $pkg 2>/dev/null || {
            print_warning "تعذر تثبيت $pkg، جاري المحاولة بديل..."
            pkg install -y $pkg 2>/dev/null || true
        }
    done
    
    print_success "تم تثبيت الحزم المطلوبة"
}

# ================================================================================
# Clone Repository
# ================================================================================

clone_repo() {
    print_step "استنساخ المشروع"
    
    cd ~
    
    if [ -d "multaqa" ]; then
        print_warning "مجلد multaqa موجود بالفعل، جاري الحذف..."
        rm -rf multaqa
    fi
    
    print_status "استنساخ المستودع..."
    git clone https://github.com/hamchado/Laravel.git multaqa
    
    cd multaqa
    
    print_success "تم استنساخ المشروع بنجاح"
}

# ================================================================================
# Install PHP Dependencies
# ================================================================================

install_composer_deps() {
    print_step "تثبيت اعتماديات PHP (Composer)"
    
    print_status "تثبيت Composer dependencies..."
    
    # Check if composer is available
    if ! command -v composer &> /dev/null; then
        print_status "تثبيت Composer..."
        php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
        php composer-setup.php --install-dir=$PREFIX/bin --filename=composer
        php -r "unlink('composer-setup.php');"
    fi
    
    # Install dependencies
    composer install --no-interaction --prefer-dist --optimize-autoloader
    
    print_success "تم تثبيت اعتماديات Composer"
}

# ================================================================================
# Setup Environment
# ================================================================================

setup_environment() {
    print_step "إعداد ملف البيئة"
    
    if [ ! -f ".env" ]; then
        print_status "إنشاء ملف .env..."
        cp .env.example .env
        
        # Update environment variables for SQLite
        sed -i 's/DB_CONNECTION=.*/DB_CONNECTION=sqlite/' .env
        sed -i 's/DB_DATABASE=.*/DB_DATABASE=database\/database.sqlite/' .env
        sed -i 's/APP_ENV=.*/APP_ENV=local/' .env
        sed -i 's/APP_DEBUG=.*/APP_DEBUG=true/' .env
        sed -i 's/APP_URL=.*/APP_URL=http:\/\/localhost:8000/' .env
        sed -i 's/SESSION_DRIVER=.*/SESSION_DRIVER=database/' .env
        sed -i 's/CACHE_DRIVER=.*/CACHE_DRIVER=file/' .env
        sed -i 's/QUEUE_CONNECTION=.*/QUEUE_CONNECTION=sync/' .env
        
        # Generate app key
        php artisan key:generate
        
        print_success "تم إنشاء ملف .env"
    else
        print_warning "ملف .env موجود بالفعل"
    fi
}

# ================================================================================
# Setup Database
# ================================================================================

setup_database() {
    print_step "إعداد قاعدة البيانات"
    
    # Create SQLite database file
    print_status "إنشاء ملف قاعدة البيانات..."
    mkdir -p database
    touch database/database.sqlite
    
    # Download the SQL file if not exists
    if [ ! -f "database/multaqa_dental_system.sql" ]; then
        print_status "تحميل ملف قاعدة البيانات..."
        curl -L -o database/multaqa_dental_system.sql \
            "https://raw.githubusercontent.com/hamchado/Laravel/main/database/multaqa_dental_system.sql"
    fi
    
    # Import the SQL file
    print_status "استيراد قاعدة البيانات..."
    sqlite3 database/database.sqlite < database/multaqa_dental_system.sql
    
    print_success "تم إعداد قاعدة البيانات بنجاح"
}

# ================================================================================
# Run Migrations (if needed)
# ================================================================================

run_migrations() {
    print_step "تشغيل الهجرات"
    
    print_status "تشغيل migrations..."
    php artisan migrate --force 2>/dev/null || {
        print_warning "بعض الهجرات موجودة بالفعل، جاري التخطي..."
    }
    
    print_success "تم تشغيل الهجرات"
}

# ================================================================================
# Seed Database
# ================================================================================

seed_database() {
    print_step "تعبئة قاعدة البيانات"
    
    # Download DatabaseSeeder if not exists
    if [ ! -f "database/seeders/DatabaseSeederNew.php" ]; then
        print_status "تحميل DatabaseSeeder..."
        curl -L -o database/seeders/DatabaseSeederNew.php \
            "https://raw.githubusercontent.com/hamchado/Laravel/main/database/seeders/DatabaseSeederNew.php"
    fi
    
    # Rename to DatabaseSeeder.php if needed
    if [ -f "database/seeders/DatabaseSeederNew.php" ] && [ ! -f "database/seeders/DatabaseSeeder.php" ]; then
        cp database/seeders/DatabaseSeederNew.php database/seeders/DatabaseSeeder.php
    fi
    
    print_status "تعبئة البيانات الافتراضية..."
    php artisan db:seed --class=DatabaseSeeder --force
    
    print_success "تم تعبئة قاعدة البيانات بنجاح"
}

# ================================================================================
# Setup Storage
# ================================================================================

setup_storage() {
    print_step "إعداد التخزين"
    
    print_status "إنشاء روابط التخزين..."
    php artisan storage:link 2>/dev/null || true
    
    # Create necessary directories
    mkdir -p storage/app/public/patients
    mkdir -p storage/app/public/cases
    mkdir -p storage/app/public/panorama
    mkdir -p storage/framework/cache
    mkdir -p storage/framework/sessions
    mkdir -p storage/framework/views
    mkdir -p storage/logs
    
    # Set permissions
    chmod -R 755 storage
    chmod -R 755 bootstrap/cache
    
    print_success "تم إعداد التخزين"
}

# ================================================================================
# Cache Configuration
# ================================================================================

cache_config() {
    print_step "تخزين الإعدادات"
    
    print_status "تحسين الأداء..."
    php artisan config:cache 2>/dev/null || true
    php artisan route:cache 2>/dev/null || true
    php artisan view:cache 2>/dev/null || true
    
    print_success "تم تخزين الإعدادات"
}

# ================================================================================
# Create Start Script
# ================================================================================

create_start_script() {
    print_step "إنشاء سكريبت التشغيل"
    
    cat > ~/start_multaqa.sh << 'EOF'
#!/bin/bash

cd ~/multaqa

echo "🦷 تشغيل منصة ملتقى..."
echo ""

# Clear caches for fresh start
php artisan cache:clear 2>/dev/null
php artisan config:clear 2>/dev/null

# Start server
echo "🚀 جاري تشغيل السيرفر على:"
echo "   📱 Local:   http://localhost:8000"
echo "   🌐 Network: http://$(ifconfig 2>/dev/null | grep -Eo 'inet (addr:)?([0-9]*\.){3}[0-9]*' | grep -Eo '([0-9]*\.){3}[0-9]*' | grep -v '127.0.0.1' | head -n 1):8000"
echo ""
echo "⚠️  اضغط Ctrl+C لإيقاف السيرفر"
echo ""

php artisan serve --host=0.0.0.0 --port=8000
EOF

    chmod +x ~/start_multaqa.sh
    
    print_success "تم إنشاء سكريبت التشغيل"
}

# ================================================================================
# Display Login Info
# ================================================================================

display_info() {
    print_step "✅ تم الإعداد بنجاح!"
    
    echo ""
    echo -e "${GREEN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
    echo -e "${GREEN}  🎉 تم إعداد منصة ملتقى بنجاح!${NC}"
    echo -e "${GREEN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
    echo ""
    echo -e "${CYAN}📱 بيانات تسجيل الدخول الافتراضية:${NC}"
    echo ""
    echo -e "  ${YELLOW}الطالب:${NC}"
    echo -e "    البريد: ${GREEN}student@multaqa.com${NC}"
    echo -e "    كلمة المرور: ${GREEN}Student@123${NC}"
    echo ""
    echo -e "  ${YELLOW}المشرف الإداري:${NC}"
    echo -e "    البريد: ${GREEN}admin@multaqa.com${NC}"
    echo -e "    كلمة المرور: ${GREEN}Admin@123${NC}"
    echo ""
    echo -e "  ${YELLOW}المشرف السريري:${NC}"
    echo -e "    البريد: ${GREEN}supervisor@multaqa.com${NC}"
    echo -e "    كلمة المرور: ${GREEN}Super@123${NC}"
    echo ""
    echo -e "  ${YELLOW}مدير النظام:${NC}"
    echo -e "    البريد: ${GREEN}ayham@multaqa.com${NC}"
    echo -e "    كلمة المرور: ${GREEN}Ayham@123${NC}"
    echo ""
    echo -e "${CYAN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
    echo ""
    echo -e "${GREEN}🚀 لتشغيل السيرفر:${NC}"
    echo -e "   ${YELLOW}~/start_multaqa.sh${NC}"
    echo ""
    echo -e "${GREEN}📂 مجلد المشروع:${NC}"
    echo -e "   ${YELLOW}~/multaqa${NC}"
    echo ""
    echo -e "${CYAN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
    echo ""
}

# ================================================================================
# Start Server
# ================================================================================

start_server() {
    print_step "🚀 تشغيل السيرفر"
    
    echo ""
    echo -e "${GREEN}جاري تشغيل السيرفر...${NC}"
    echo ""
    
    # Get IP address
    IP=$(ifconfig 2>/dev/null | grep -Eo 'inet (addr:)?([0-9]*\.){3}[0-9]*' | grep -Eo '([0-9]*\.){3}[0-9]*' | grep -v '127.0.0.1' | head -n 1)
    
    echo -e "${CYAN}🌐 روابط الوصول:${NC}"
    echo ""
    echo -e "  ${GREEN}Local:${NC}   http://localhost:8000"
    [ -n "$IP" ] && echo -e "  ${GREEN}Network:${NC} http://$IP:8000"
    echo ""
    echo -e "${YELLOW}⚠️  اضغط Ctrl+C لإيقاف السيرفر${NC}"
    echo ""
    
    # Clear caches
    php artisan cache:clear 2>/dev/null
    php artisan config:clear 2>/dev/null
    
    # Start server
    php artisan serve --host=0.0.0.0 --port=8000
}

# ================================================================================
# Main Function
# ================================================================================

main() {
    print_banner
    
    check_termux
    update_packages
    install_packages
    clone_repo
    install_composer_deps
    setup_environment
    setup_database
    run_migrations
    seed_database
    setup_storage
    cache_config
    create_start_script
    display_info
    
    # Ask user if they want to start server now
    echo -e "${CYAN}هل تريد تشغيل السيرفر الآن؟ (y/n)${NC}"
    read -r response
    
    if [[ "$response" =~ ^([yY][eE][sS]|[yY])$ ]]; then
        start_server
    else
        echo ""
        echo -e "${GREEN}✅ تم الإعداد بنجاح!${NC}"
        echo -e "${YELLOW}لتشغيل السيرفر لاحقاً، استخدم:${NC} ${CYAN}~/start_multaqa.sh${NC}"
        echo ""
    fi
}

# ================================================================================
# Run Main
# ================================================================================

main "$@"
