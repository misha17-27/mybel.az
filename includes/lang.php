<?php
/**
 * includes/lang.php — PUBLİK saytın interfeys sətirlərinin tərcüməsi (AZ / RU / EN).
 * Yalnız publik bootstrap-dan yüklənir (admin öz t()-sini istifadə edir).
 * Şablonlarda __('key') çağırın. Dil $GLOBALS['LANG'] ilə (config.php təyin edir).
 */

$UI_T = [
'az' => [
  'skip'=>'Əsas məzmuna keç','breadcrumb'=>'Naviqasiya izi','main_menu'=>'Əsas menyu',
  'menu_open'=>'Menyunu aç','menu_close'=>'Menyunu bağla',
  'nav_home'=>'Ana səhifə','nav_about'=>'Şirkət haqqında','nav_projects'=>'Layihələr','nav_services'=>'Xidmətlər','nav_clients'=>'Müştərilər','nav_contact'=>'Əlaqə',
  'btn_our_projects'=>'Layihələrimiz','btn_contact_us'=>'Bizimlə əlaqə','more'=>'Ətraflı','view_project'=>'Layihəyə bax','all_projects'=>'Bütün layihələr','all_services'=>'Bütün xidmətlər','get_quote'=>'Təklif al',
  'filter_all'=>'Hamısı','no_projects_cat'=>'Bu kateqoriyada hələ layihə yoxdur.','pages_aria'=>'Səhifələr','prev'=>'Əvvəlki','next'=>'Növbəti',
  'd_category'=>'Kateqoriya','d_location'=>'Məkan','d_year'=>'İl','gallery'=>'Qalereya','img_main'=>'əsas görüntü','img_photo'=>'şəkil',
  'proj_not_found'=>'Layihə tapılmadı','svc_not_found'=>'Xidmət tapılmadı','not_found_short'=>'Tapılmadı',
  'related_title'=>'Bu xidmətə aid layihələr','no_related'=>'Bu xidmət üzrə layihələr tezliklə əlavə olunacaq.',
  'cta_about_title'=>'Birlikdə işləyək','cta_about_text'=>'Növbəti layihənizi MYBEL Concept ilə həyata keçirin.','cta_about_btn'=>'Əlaqə saxla',
  'xid_cta_title'=>'Sizə uyğun həll axtarırıq','xid_cta_text'=>'Ehtiyacınızı bizə bildirin — layihə və qiymət təklifini hazırlayaq.',
  'c_name'=>'Ad, Soyad','c_phone'=>'Telefon','c_email'=>'E-poçt','c_message'=>'Mesaj','c_send'=>'Göndər','c_required'=>'* işarəli sahələr mütləqdir.',
  'c_success'=>'Təşəkkür edirik! Müraciətiniz qəbul olundu, tezliklə sizinlə əlaqə saxlayacağıq.',
  'err_spam'=>'Spam aşkarlandı.','err_robot'=>'Zəhmət olmasa robot olmadığınızı təsdiqləyin.','err_ratelimit'=>'Çox sayda müraciət göndərilib. Bir saatdan sonra yenidən cəhd edin.','err_namemsg'=>'Zəhmət olmasa ad və mesaj sahələrini düzgün doldurun.','err_email'=>'E-poçt ünvanı düzgün deyil.','err_phone'=>'Telefon nömrəsi düzgün deyil.',
  'ci_addr'=>'Ünvan','ci_hours'=>'İş saatı','map_title'=>'Xəritədə MYBEL Concept',
  'footer_menu'=>'Kateqoriyalar','rights'=>'Bütün hüquqlar qorunur.',
  'e404_h'=>'Səhifə tapılmadı','e404_text'=>'Axtardığınız səhifə mövcud deyil və ya köçürülüb.','e404_btn'=>'Ana səhifəyə qayıt',
],
'ru' => [
  'skip'=>'Перейти к содержимому','breadcrumb'=>'Навигация','main_menu'=>'Главное меню',
  'menu_open'=>'Открыть меню','menu_close'=>'Закрыть меню',
  'nav_home'=>'Главная','nav_about'=>'О компании','nav_projects'=>'Проекты','nav_services'=>'Услуги','nav_clients'=>'Клиенты','nav_contact'=>'Контакты',
  'btn_our_projects'=>'Наши проекты','btn_contact_us'=>'Связаться с нами','more'=>'Подробнее','view_project'=>'Смотреть проект','all_projects'=>'Все проекты','all_services'=>'Все услуги','get_quote'=>'Получить предложение',
  'filter_all'=>'Все','no_projects_cat'=>'В этой категории пока нет проектов.','pages_aria'=>'Страницы','prev'=>'Предыдущая','next'=>'Следующая',
  'd_category'=>'Категория','d_location'=>'Локация','d_year'=>'Год','gallery'=>'Галерея','img_main'=>'главное изображение','img_photo'=>'фото',
  'proj_not_found'=>'Проект не найден','svc_not_found'=>'Услуга не найдена','not_found_short'=>'Не найдено',
  'related_title'=>'Проекты по этой услуге','no_related'=>'Проекты по этой услуге скоро появятся.',
  'cta_about_title'=>'Давайте работать вместе','cta_about_text'=>'Реализуйте свой следующий проект вместе с MYBEL Concept.','cta_about_btn'=>'Связаться',
  'xid_cta_title'=>'Подберём решение для вас','xid_cta_text'=>'Расскажите о вашей задаче — подготовим проект и предложение по цене.',
  'c_name'=>'Имя, фамилия','c_phone'=>'Телефон','c_email'=>'E-mail','c_message'=>'Сообщение','c_send'=>'Отправить','c_required'=>'* поля обязательны для заполнения.',
  'c_success'=>'Спасибо! Ваша заявка принята, мы свяжемся с вами в ближайшее время.',
  'err_spam'=>'Обнаружен спам.','err_robot'=>'Пожалуйста, подтвердите, что вы не робот.','err_ratelimit'=>'Отправлено слишком много заявок. Повторите попытку через час.','err_namemsg'=>'Пожалуйста, корректно заполните поля имени и сообщения.','err_email'=>'Некорректный адрес e-mail.','err_phone'=>'Некорректный номер телефона.',
  'ci_addr'=>'Адрес','ci_hours'=>'Часы работы','map_title'=>'MYBEL Concept на карте',
  'footer_menu'=>'Категории','rights'=>'Все права защищены.',
  'e404_h'=>'Страница не найдена','e404_text'=>'Запрашиваемая страница не существует или была перемещена.','e404_btn'=>'Вернуться на главную',
],
'en' => [
  'skip'=>'Skip to content','breadcrumb'=>'Breadcrumb','main_menu'=>'Main menu',
  'menu_open'=>'Open menu','menu_close'=>'Close menu',
  'nav_home'=>'Home','nav_about'=>'About','nav_projects'=>'Projects','nav_services'=>'Services','nav_clients'=>'Clients','nav_contact'=>'Contact',
  'btn_our_projects'=>'Our projects','btn_contact_us'=>'Contact us','more'=>'Learn more','view_project'=>'View project','all_projects'=>'All projects','all_services'=>'All services','get_quote'=>'Get a quote',
  'filter_all'=>'All','no_projects_cat'=>'No projects in this category yet.','pages_aria'=>'Pages','prev'=>'Previous','next'=>'Next',
  'd_category'=>'Category','d_location'=>'Location','d_year'=>'Year','gallery'=>'Gallery','img_main'=>'main image','img_photo'=>'photo',
  'proj_not_found'=>'Project not found','svc_not_found'=>'Service not found','not_found_short'=>'Not found',
  'related_title'=>'Projects for this service','no_related'=>'Projects for this service will be added soon.',
  'cta_about_title'=>'Let’s work together','cta_about_text'=>'Bring your next project to life with MYBEL Concept.','cta_about_btn'=>'Get in touch',
  'xid_cta_title'=>'We’ll find the right solution for you','xid_cta_text'=>'Tell us what you need — we’ll prepare a project and a quote.',
  'c_name'=>'Full name','c_phone'=>'Phone','c_email'=>'E-mail','c_message'=>'Message','c_send'=>'Send','c_required'=>'* required fields.',
  'c_success'=>'Thank you! Your request has been received, we’ll get in touch with you shortly.',
  'err_spam'=>'Spam detected.','err_robot'=>'Please confirm you are not a robot.','err_ratelimit'=>'Too many requests. Please try again in an hour.','err_namemsg'=>'Please fill in the name and message fields correctly.','err_email'=>'Invalid e-mail address.','err_phone'=>'Invalid phone number.',
  'ci_addr'=>'Address','ci_hours'=>'Working hours','map_title'=>'MYBEL Concept on the map',
  'footer_menu'=>'Categories','rights'=>'All rights reserved.',
  'e404_h'=>'Page not found','e404_text'=>'The page you are looking for doesn’t exist or has been moved.','e404_btn'=>'Back to home',
],
];

if (!function_exists('__')) {
    function __(string $key): string {
        global $UI_T, $LANG;
        $l = $LANG ?? 'az';
        return $UI_T[$l][$key] ?? ($UI_T['az'][$key] ?? $key);
    }
}
