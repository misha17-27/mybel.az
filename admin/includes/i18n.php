<?php
/**
 * admin/includes/i18n.php — admin panelin 3 dilli interfeysi (RU / EN / AZ).
 * Dil ?lang=... -> cookie -> default(ru) sırası ilə təyin olunur.
 * Şablonlarda t('key') istifadə edin.
 */

$ADMIN_LANGS = ['ru' => 'RU', 'en' => 'EN', 'az' => 'AZ'];

$GLOBALS['ADMIN_LANG'] = 'ru';
if (isset($_GET['lang']) && isset($ADMIN_LANGS[$_GET['lang']])) {
    $GLOBALS['ADMIN_LANG'] = $_GET['lang'];
    setcookie('mybel_admin_lang', $_GET['lang'], time() + 31536000, '/');
} elseif (isset($_COOKIE['mybel_admin_lang']) && isset($ADMIN_LANGS[$_COOKIE['mybel_admin_lang']])) {
    $GLOBALS['ADMIN_LANG'] = $_COOKIE['mybel_admin_lang'];
}

function t(string $key): string {
    global $ADMIN_T, $ADMIN_LANG;
    return $ADMIN_T[$ADMIN_LANG][$key] ?? ($ADMIN_T['ru'][$key] ?? $key);
}

$ADMIN_T = [
'ru' => [
  // ümumi / layout
  'g_main'=>'ОСНОВНОЕ','g_content'=>'КОНТЕНТ','g_settings'=>'НАСТРОЙКИ',
  'n_dashboard'=>'Обзор','n_texts'=>'Тексты сайта','n_projects'=>'Проекты','n_areas'=>'Сферы деятельности',
  'n_services'=>'Услуги','n_clients'=>'Клиенты','n_contacts'=>'Контакты и соцсети','n_messages'=>'Заявки с сайта',
  'n_seo'=>'SEO','n_mail'=>'Почта (SMTP)','n_security'=>'Безопасность','n_users'=>'Пользователи','n_profile'=>'Мой профиль',
  'open_site'=>'Открыть сайт','logout'=>'Выйти','logged_as'=>'Вы вошли как','menu'=>'Меню',
  'save'=>'Сохранить','save_all'=>'Сохранить всё','add'=>'Добавить','delete'=>'Удалить','edit'=>'Изменить',
  'back_list'=>'К списку','show_site'=>'Показывать на сайте','show'=>'Показ','order'=>'Порядок','name'=>'Название',
  'photo'=>'Фото','title_f'=>'Заголовок','desc_f'=>'Описание','saved'=>'Изменения сохранены.','deleted'=>'Удалено.',
  // login
  'login_title'=>'Вход в панель','login_sub'=>'Управление контентом сайта','email'=>'E-mail','password'=>'Пароль',
  'login_btn'=>'Войти','login_bad'=>'Неверный e-mail или пароль. Осталось попыток:','login_many'=>'Слишком много попыток. Попробуйте через 15 минут.','login_robot'=>'Подтвердите, что вы не робот.',
  'login_id'=>'E-mail или имя пользователя','login_forgot'=>'Забыли пароль?','show_pass'=>'Показать пароль',
  'forgot_title'=>'Восстановление пароля','forgot_sub'=>'Введите e-mail — пришлём ссылку для сброса.','forgot_email'=>'E-mail','forgot_send'=>'Отправить ссылку','forgot_sent'=>'Если такой e-mail зарегистрирован, мы отправили ссылку для сброса.','forgot_back'=>'Вернуться ко входу',
  'reset_title'=>'Новый пароль','reset_new'=>'Новый пароль (мин. 8 символов)','reset_confirm'=>'Повторите пароль','reset_save'=>'Сохранить пароль','reset_done'=>'Пароль изменён. Войдите с новым паролем.','reset_bad'=>'Ссылка недействительна или устарела.','reset_mismatch'=>'Пароли не совпадают.','reset_short'=>'Минимум 8 символов.','reset_subj'=>'Восстановление пароля — MYBEL','reset_body'=>'Для сброса пароля перейдите по ссылке (действует 1 час):',
  // dashboard
  'd_projects'=>'проектов','d_areas'=>'сфер деятельности','d_services'=>'услуг','d_new'=>'новых заявок',
  'd_quick'=>'Быстрые действия','d_quick_h'=>'С чего обычно начинают.','d_addproj'=>'Добавить проект','d_edittext'=>'Редактировать тексты',
  'd_pub'=>'Публикация','d_pub_h'=>'Изменения сохраняются сразу и сайт отдаёт их без пересборки.','d_home'=>'Главная','d_contacts'=>'Контакты',
  // texts
  't_title'=>'Тексты сайта','t_common'=>'Общие','t_legal'=>'Юр. название (футер)','t_slogan'=>'Слоган','t_shortdesc'=>'Короткое описание (футер/SEO fallback)',
  't_hero'=>'Главный экран (Hero)','t_eyebrow'=>'Надзаголовок','t_hero_title'=>'Заголовок (перенос строки = новая строка)','t_hero_lead'=>'Подзаголовок',
  't_about'=>'Блок «О компании» (на главной)','t_about_text'=>'Текст (пустая строка = новый абзац)','t_saved'=>'Тексты сохранены. Сайт обновится сразу.',
  't_video'=>'Видео на странице «О компании»','t_video_h'=>'Ссылка YouTube / Vimeo или прямой .mp4. Пусто — на сайте будет заглушка «место под видео».',
  // projects / areas
  'p_edit'=>'Редактировать проект','p_new'=>'Новый проект','p_slug'=>'Slug (URL, необязательно)','p_slug_ph'=>'авто из заголовка',
  'p_cat'=>'Категория','p_loc'=>'Локация','p_year'=>'Год','p_order_hint'=>'Порядок (меньше = выше)','p_excerpt'=>'Краткое описание (в карточке)',
  'p_body'=>'Полный текст','p_cover'=>'Обложка','p_or_url'=>'или ссылка https://...','p_gallery'=>'Галерея','p_remove'=>'удалить','p_or_urls'=>'или ссылки через пробел',
  'p_all'=>'Все проекты','p_all_h'=>'Порядок и видимость управляются в карточке проекта.','p_new_btn'=>'+ Новый проект','p_deleted'=>'Проект удалён.','p_need_title'=>'Заголовок обязателен.','p_saved'=>'Проект сохранён.','p_confirm'=>'Удалить проект?','p_services'=>'Услуги, где показывать проект','p_services_h'=>'Проект появится в блоке «Связанные проекты» на страницах выбранных услуг.',
  'a_title'=>'Сферы деятельности','a_edit'=>'Редактировать сферу','a_new'=>'Новая сфера','a_new_btn'=>'+ Новая сфера','a_h'=>'Рестораны, отели, частные дома и т.д.','a_deleted'=>'Сфера удалена.','a_saved'=>'Сфера сохранена.','a_body'=>'Полный текст (HTML разрешён)',
  // services
  's_title'=>'Услуги','s_add'=>'Добавить услугу','s_icon'=>'Иконка','s_add_btn'=>'+ Добавить','s_all'=>'Все услуги','s_added'=>'Услуга добавлена.','s_deleted'=>'Услуга удалена.','s_saved'=>'Услуга сохранена.',
  's_new'=>'Новая услуга','s_edit'=>'Редактировать услугу','s_new_btn'=>'+ Новая услуга','s_all_h'=>'Внутри каждой услуги можно привязать проекты.','s_body'=>'Детальный текст (страница услуги, HTML разрешён)','s_short'=>'Краткое описание (в карточке)','s_link'=>'Связанные проекты','s_link_h'=>'Отметьте проекты этой услуги — они покажутся под описанием на её странице.','s_noproj'=>'Проектов пока нет — сначала добавьте проекты.',
  'ic_kitchen'=>'Кухня','ic_table'=>'Стол','ic_bed'=>'Кровать','ic_wardrobe'=>'Шкаф','ic_sofa'=>'Диван','ic_design'=>'Дизайн',
  // clients
  'c_title'=>'Клиенты','c_add'=>'Добавить клиента','c_add_h'=>'Лучше всего — логотип на прозрачном фоне (PNG/SVG). До 3 МБ.','c_link'=>'Ссылка (необязательно)','c_logo_file'=>'Файл логотипа','c_logo_url'=>'или ссылка на логотип','c_add_btn'=>'Добавить клиента',
  'c_list'=>'Список клиентов','c_list_h'=>'Логотипы показываются бегущей лентой. Порядок — по числу.','c_logo'=>'Лого','c_added'=>'Клиент добавлен.','c_deleted'=>'Клиент удалён.','c_need'=>'Укажите название или логотип.',
  // contacts
  'k_title'=>'Контакты и соцсети','k_on_site'=>'Контакты на сайте','k_phone'=>'Телефон','k_addr'=>'Адрес','k_hours'=>'Часы работы','k_map'=>'Карта (ссылка для встраивания, embed)',
  'k_social'=>'WhatsApp и соцсети','k_social_h'=>'WhatsApp: только цифры номера. Соцсети — полные ссылки (пустые не показываются).','k_wa'=>'Номер WhatsApp','k_saved'=>'Контакты сохранены.',
  // seo
  'o_title'=>'Поисковая оптимизация','o_h'=>'Эти данные видят Google и соцсети при отправке ссылки.','o_mt'=>'Заголовок главной (Title, 50–60 символов)','o_md'=>'Описание (Description, 140–160 символов)',
  'o_og'=>'Картинка для соцсетей (1200×630)','o_or'=>'или ссылка /assets/... или https://...','o_vis'=>'Видимость в поиске','o_open'=>'Открыт для поисковиков','o_closed'=>'Закрыт (noindex)','o_saved'=>'SEO сохранено.',
  'o_keywords'=>'Ключевые слова','o_keywords_h'=>'Через запятую. Google их почти не учитывает, но не помешают.','o_images'=>'Картинки: соцсети и favicon','o_favicon'=>'Favicon (иконка вкладки)','o_biz'=>'Бизнес (микроразметка Schema.org)','o_biz_h'=>'Данные для расширенных сниппетов и локального поиска Google.','o_orgtype'=>'Тип организации','o_price'=>'Ценовой диапазон','o_analytics'=>'Аналитика и проверка сайта','o_ga'=>'Google Analytics (GA4)','o_ga_h'=>'ID вида G-XXXXXXXXXX из вашего ресурса GA4.','o_gsc'=>'Google Search Console — код проверки','o_gsc_h'=>'Значение content из тега google-site-verification (способ «HTML-тег»).',
  // messages
  'm_title'=>'Заявки с сайта','m_head'=>'Сообщения из формы обратной связи','m_total'=>'Всего:','m_unread'=>'Непрочитанных:','m_readall'=>'Отметить все прочитанными','m_none'=>'Пока нет заявок.',
  'm_new'=>'новая','m_read'=>'Прочитано','m_unreadbtn'=>'В непрочитанные','m_phone'=>'Тел:','m_readall_done'=>'Все отмечены прочитанными.','m_deleted'=>'Заявка удалена.','m_confirm'=>'Удалить заявку?',
  // users
  'u_title'=>'Пользователи','u_add'=>'Добавить пользователя','u_add_h'=>'Роль «Администратор» — полный доступ. «Редактор» — только контент (без пользователей).','u_pass8'=>'Пароль (мин. 8 символов)','u_role'=>'Роль','u_editor'=>'Редактор','u_admin'=>'Администратор',
  'u_all'=>'Все пользователи','u_all_h'=>'Поле пароля оставьте пустым, если менять не нужно.','u_newpass'=>'Новый пароль','u_active'=>'Активен','u_login'=>'Вход','u_you'=>'это вы','u_save'=>'Сохранить изменения',
  'u_bad'=>'Заполните имя, корректный e-mail и пароль (мин. 8 символов).','u_exists'=>'Пользователь с таким e-mail уже есть.','u_added'=>'Пользователь добавлен.','u_self'=>'Нельзя удалить самого себя.','u_deleted'=>'Пользователь удалён.','u_need_admin'=>'Должен остаться хотя бы один активный администратор.','u_confirm'=>'Удалить пользователя?',
  // profile
  'r_title'=>'Мой профиль','r_profile'=>'Профиль','r_login'=>'E-mail (логин):','r_role'=>'роль:','r_chpass'=>'Смена пароля','r_chpass_h'=>'Заполните, только если хотите изменить пароль.','r_cur'=>'Текущий пароль','r_new'=>'Новый пароль','r_rep'=>'Повторите',
  'r_bad_cur'=>'Текущий пароль неверный.','r_short'=>'Новый пароль — минимум 8 символов.','r_nomatch'=>'Пароли не совпадают.','r_saved'=>'Профиль обновлён.',
  // security
  'x_title'=>'Cloudflare Turnstile (капча)','x_on'=>'включена','x_off'=>'выключена','x_h'=>'Защищает вход в панель и форму на сайте от ботов. Бесплатно, без «разгадывания картинок».','x_enable'=>'Включить Turnstile','x_site'=>'Site Key (публичный ключ)','x_secret'=>'Secret Key (секретный ключ)','x_unchanged'=>'•••• без изменений','x_saved'=>'Настройки безопасности сохранены.',
  'x_where'=>'Где взять ключи','x_w1'=>'Зайдите на dash.cloudflare.com → раздел Turnstile.','x_w2'=>'Нажмите Add widget. Domain — укажите mybel.az (и www.mybel.az).','x_w3'=>'Widget Mode — Managed.','x_w4'=>'Скопируйте Site Key и Secret Key в поля выше и включите галочку.',
  'x_prot'=>'Что уже защищено','x_p1'=>'Пароли хранятся необратимым хэшем (bcrypt).','x_p2'=>'Все формы защищены от CSRF.','x_p3'=>'Ограничение попыток входа: 10 за 15 минут с одного IP.','x_p4'=>'Скрытая ловушка для ботов (honeypot) в формах.','x_p5'=>'Папки данных закрыты от веба; в загрузках запрещено выполнение PHP.',
  // mail
  'l_title'=>'Настройки SMTP','l_h'=>'Через SMTP письма доходят надёжнее, чем через стандартную функцию сервера. Если оставить пустым — используется mail().','l_host'=>'SMTP-сервер','l_port'=>'Порт','l_enc'=>'Шифрование','l_tls'=>'STARTTLS (587)','l_ssl'=>'SSL/TLS (465)','l_none'=>'Без шифрования',
  'l_user'=>'Пользователь (обычно полный адрес почты)','l_from'=>'Адрес отправителя (From)','l_fromname'=>'Имя отправителя','l_saved'=>'Настройки SMTP сохранены.',
  'l_test'=>'Проверка отправки','l_test_h'=>'Отправим тестовое письмо, чтобы убедиться, что настройки верные. Сначала сохраните настройки.','l_to'=>'Адрес получателя','l_send'=>'Отправить тест','l_bad_to'=>'Укажите корректный e-mail получателя.','l_sent'=>'Письмо отправлено на','l_err'=>'Ошибка:',
  'l_where'=>'Где взять данные','l_where_h'=>'В cPanel → Email Accounts → у нужного ящика нажмите Connect Devices. Там указаны сервер, порт и способ шифрования. Пользователь — полный адрес почты, пароль — от этого ящика.',
  'unchanged'=>'•••• без изменений',
  'th_home'=>'Разделы главной страницы','th_projects'=>'Секция «Проекты»','th_services'=>'Секция «Услуги»','th_clients'=>'Секция «Клиенты»','th_cta'=>'Призыв к действию (CTA)','th_desc'=>'Описание','th_btn'=>'Текст кнопки',
  'ta_page'=>'Страница «О компании»','ta_lead'=>'Подзаголовок (под заголовком)','ta_intro'=>'Блок «Кто мы»','ta_mission'=>'Миссия','ta_approach'=>'Подход','ta_stats'=>'Цифры (статистика)','ta_num'=>'Число','ta_label'=>'Подпись','ta_text'=>'Текст',
  'n_pages'=>'Страницы','pg_all'=>'Все страницы','pg_all_h'=>'Выберите страницу, чтобы отредактировать её тексты.','pg_col'=>'Страница','pg_saved'=>'Страница сохранена.','pg_hero_title'=>'Заголовок страницы (H1)','pg_subtitle'=>'Подзаголовок','pg_image'=>'Изображение',
  'pg_seo'=>'SEO страницы','pg_seo_title'=>'Meta-заголовок (Title)','pg_seo_desc'=>'Meta-описание (Description)','pg_seo_h'=>'Что видит Google в результатах. Пусто — подставится по умолчанию.','o_home_note'=>'Заголовок и описание каждой страницы (в т.ч. главной) — в разделе «Страницы».','pg_home'=>'Главная','pg_about'=>'О компании','pg_projects'=>'Проекты','pg_services'=>'Услуги','pg_clients'=>'Клиенты','pg_contact'=>'Контакты','t_common_h'=>'Глобальные тексты: используются в футере, SEO и по всему сайту.',
],
'en' => [
  'g_main'=>'MAIN','g_content'=>'CONTENT','g_settings'=>'SETTINGS',
  'n_dashboard'=>'Overview','n_texts'=>'Site texts','n_projects'=>'Projects','n_areas'=>'Areas',
  'n_services'=>'Services','n_clients'=>'Clients','n_contacts'=>'Contacts & social','n_messages'=>'Form requests',
  'n_seo'=>'SEO','n_mail'=>'Mail (SMTP)','n_security'=>'Security','n_users'=>'Users','n_profile'=>'My profile',
  'open_site'=>'Open site','logout'=>'Log out','logged_as'=>'Signed in as','menu'=>'Menu',
  'save'=>'Save','save_all'=>'Save all','add'=>'Add','delete'=>'Delete','edit'=>'Edit',
  'back_list'=>'Back to list','show_site'=>'Show on site','show'=>'Show','order'=>'Order','name'=>'Name',
  'photo'=>'Photo','title_f'=>'Title','desc_f'=>'Description','saved'=>'Changes saved.','deleted'=>'Deleted.',
  'login_title'=>'Sign in','login_sub'=>'Website content management','email'=>'E-mail','password'=>'Password',
  'login_btn'=>'Sign in','login_bad'=>'Wrong e-mail or password. Attempts left:','login_many'=>'Too many attempts. Try again in 15 minutes.','login_robot'=>'Please confirm you are not a robot.',
  'login_id'=>'E-mail or username','login_forgot'=>'Forgot password?','show_pass'=>'Show password',
  'forgot_title'=>'Password recovery','forgot_sub'=>'Enter your e-mail — we will send a reset link.','forgot_email'=>'E-mail','forgot_send'=>'Send link','forgot_sent'=>'If that e-mail is registered, we have sent a reset link.','forgot_back'=>'Back to login',
  'reset_title'=>'New password','reset_new'=>'New password (min. 8 chars)','reset_confirm'=>'Repeat password','reset_save'=>'Save password','reset_done'=>'Password changed. Sign in with the new one.','reset_bad'=>'The link is invalid or expired.','reset_mismatch'=>'Passwords do not match.','reset_short'=>'At least 8 characters.','reset_subj'=>'Password recovery — MYBEL','reset_body'=>'To reset your password open this link (valid for 1 hour):',
  'd_projects'=>'projects','d_areas'=>'areas','d_services'=>'services','d_new'=>'new requests',
  'd_quick'=>'Quick actions','d_quick_h'=>'Where people usually start.','d_addproj'=>'Add project','d_edittext'=>'Edit texts',
  'd_pub'=>'Publishing','d_pub_h'=>'Changes are saved instantly and served without a rebuild.','d_home'=>'Home','d_contacts'=>'Contacts',
  't_title'=>'Site texts','t_common'=>'General','t_legal'=>'Legal name (footer)','t_slogan'=>'Slogan','t_shortdesc'=>'Short description (footer / SEO fallback)',
  't_hero'=>'Hero section','t_eyebrow'=>'Eyebrow','t_hero_title'=>'Title (line break = new line)','t_hero_lead'=>'Subtitle',
  't_about'=>'“About” block (home page)','t_about_text'=>'Text (empty line = new paragraph)','t_saved'=>'Texts saved. The site updates instantly.',
  't_video'=>'Video on the “About” page','t_video_h'=>'YouTube / Vimeo link or a direct .mp4. Empty — the site shows a “video placeholder”.',
  'p_edit'=>'Edit project','p_new'=>'New project','p_slug'=>'Slug (URL, optional)','p_slug_ph'=>'auto from title',
  'p_cat'=>'Category','p_loc'=>'Location','p_year'=>'Year','p_order_hint'=>'Order (lower = higher)','p_excerpt'=>'Short description (card)',
  'p_body'=>'Full text','p_cover'=>'Cover','p_or_url'=>'or link https://...','p_gallery'=>'Gallery','p_remove'=>'remove','p_or_urls'=>'or links separated by space',
  'p_all'=>'All projects','p_all_h'=>'Order and visibility are managed inside each project.','p_new_btn'=>'+ New project','p_deleted'=>'Project deleted.','p_need_title'=>'Title is required.','p_saved'=>'Project saved.','p_confirm'=>'Delete project?','p_services'=>'Services to show this project in','p_services_h'=>'The project appears under “Linked projects” on the selected service pages.',
  'a_title'=>'Areas','a_edit'=>'Edit area','a_new'=>'New area','a_new_btn'=>'+ New area','a_h'=>'Restaurants, hotels, private homes, etc.','a_deleted'=>'Area deleted.','a_saved'=>'Area saved.','a_body'=>'Full text (HTML allowed)',
  's_title'=>'Services','s_add'=>'Add service','s_icon'=>'Icon','s_add_btn'=>'+ Add','s_all'=>'All services','s_added'=>'Service added.','s_deleted'=>'Service deleted.','s_saved'=>'Service saved.',
  's_new'=>'New service','s_edit'=>'Edit service','s_new_btn'=>'+ New service','s_all_h'=>'Inside each service you can link projects.','s_body'=>'Detail text (service page, HTML allowed)','s_short'=>'Short description (card)','s_link'=>'Linked projects','s_link_h'=>'Check the projects of this service — they appear under the description on its page.','s_noproj'=>'No projects yet — add projects first.',
  'ic_kitchen'=>'Kitchen','ic_table'=>'Table','ic_bed'=>'Bed','ic_wardrobe'=>'Wardrobe','ic_sofa'=>'Sofa','ic_design'=>'Design',
  'c_title'=>'Clients','c_add'=>'Add client','c_add_h'=>'Best is a logo on transparent background (PNG/SVG). Up to 3 MB.','c_link'=>'Link (optional)','c_logo_file'=>'Logo file','c_logo_url'=>'or logo link','c_add_btn'=>'Add client',
  'c_list'=>'Client list','c_list_h'=>'Logos scroll as a marquee. Order by number.','c_logo'=>'Logo','c_added'=>'Client added.','c_deleted'=>'Client deleted.','c_need'=>'Provide a name or a logo.',
  'k_title'=>'Contacts & social','k_on_site'=>'Contacts on site','k_phone'=>'Phone','k_addr'=>'Address','k_hours'=>'Working hours','k_map'=>'Map (embed link)',
  'k_social'=>'WhatsApp & social','k_social_h'=>'WhatsApp: digits only. Social: full links (empty are hidden).','k_wa'=>'WhatsApp number','k_saved'=>'Contacts saved.',
  'o_title'=>'Search optimization','o_h'=>'Google and social networks see this when the link is shared.','o_mt'=>'Home title (50–60 chars)','o_md'=>'Description (140–160 chars)',
  'o_og'=>'Social image (1200×630)','o_or'=>'or link /assets/... or https://...','o_vis'=>'Search visibility','o_open'=>'Open to search engines','o_closed'=>'Closed (noindex)','o_saved'=>'SEO saved.',
  'o_keywords'=>'Keywords','o_keywords_h'=>'Comma-separated. Google mostly ignores them, but they don’t hurt.','o_images'=>'Images: social & favicon','o_favicon'=>'Favicon (tab icon)','o_biz'=>'Business (Schema.org structured data)','o_biz_h'=>'Data for rich snippets and Google local search.','o_orgtype'=>'Organization type','o_price'=>'Price range','o_analytics'=>'Analytics & verification','o_ga'=>'Google Analytics (GA4)','o_ga_h'=>'ID like G-XXXXXXXXXX from your GA4 property.','o_gsc'=>'Google Search Console — verification code','o_gsc_h'=>'The content value of the google-site-verification tag (HTML tag method).',
  'm_title'=>'Form requests','m_head'=>'Messages from the contact form','m_total'=>'Total:','m_unread'=>'Unread:','m_readall'=>'Mark all as read','m_none'=>'No requests yet.',
  'm_new'=>'new','m_read'=>'Mark read','m_unreadbtn'=>'Mark unread','m_phone'=>'Tel:','m_readall_done'=>'All marked as read.','m_deleted'=>'Request deleted.','m_confirm'=>'Delete request?',
  'u_title'=>'Users','u_add'=>'Add user','u_add_h'=>'“Admin” — full access. “Editor” — content only (no users).','u_pass8'=>'Password (min. 8 chars)','u_role'=>'Role','u_editor'=>'Editor','u_admin'=>'Admin',
  'u_all'=>'All users','u_all_h'=>'Leave the password field empty to keep it unchanged.','u_newpass'=>'New password','u_active'=>'Active','u_login'=>'Login','u_you'=>'you','u_save'=>'Save changes',
  'u_bad'=>'Fill in name, a valid e-mail and a password (min. 8 chars).','u_exists'=>'A user with this e-mail already exists.','u_added'=>'User added.','u_self'=>'You cannot delete yourself.','u_deleted'=>'User deleted.','u_need_admin'=>'At least one active admin must remain.','u_confirm'=>'Delete user?',
  'r_title'=>'My profile','r_profile'=>'Profile','r_login'=>'E-mail (login):','r_role'=>'role:','r_chpass'=>'Change password','r_chpass_h'=>'Fill in only if you want to change the password.','r_cur'=>'Current password','r_new'=>'New password','r_rep'=>'Repeat',
  'r_bad_cur'=>'Current password is wrong.','r_short'=>'New password — at least 8 characters.','r_nomatch'=>'Passwords do not match.','r_saved'=>'Profile updated.',
  'x_title'=>'Cloudflare Turnstile (captcha)','x_on'=>'on','x_off'=>'off','x_h'=>'Protects panel login and the site form from bots. Free, no image puzzles.','x_enable'=>'Enable Turnstile','x_site'=>'Site Key (public)','x_secret'=>'Secret Key','x_unchanged'=>'•••• unchanged','x_saved'=>'Security settings saved.',
  'x_where'=>'Where to get the keys','x_w1'=>'Go to dash.cloudflare.com → Turnstile section.','x_w2'=>'Click Add widget. Domain — mybel.az (and www.mybel.az).','x_w3'=>'Widget Mode — Managed.','x_w4'=>'Copy Site Key and Secret Key into the fields above and tick the box.',
  'x_prot'=>'Already protected','x_p1'=>'Passwords stored as an irreversible hash (bcrypt).','x_p2'=>'All forms protected from CSRF.','x_p3'=>'Login rate limit: 10 per 15 minutes per IP.','x_p4'=>'Hidden bot trap (honeypot) in forms.','x_p5'=>'Data folders blocked from web; PHP execution disabled in uploads.',
  'l_title'=>'SMTP settings','l_h'=>'SMTP delivers mail more reliably than the default server function. Leave empty to use mail().','l_host'=>'SMTP server','l_port'=>'Port','l_enc'=>'Encryption','l_tls'=>'STARTTLS (587)','l_ssl'=>'SSL/TLS (465)','l_none'=>'None',
  'l_user'=>'User (usually full e-mail)','l_from'=>'From address','l_fromname'=>'From name','l_saved'=>'SMTP settings saved.',
  'l_test'=>'Send test','l_test_h'=>'We will send a test email to verify the settings. Save the settings first.','l_to'=>'Recipient','l_send'=>'Send test','l_bad_to'=>'Enter a valid recipient e-mail.','l_sent'=>'Email sent to','l_err'=>'Error:',
  'l_where'=>'Where to get the data','l_where_h'=>'cPanel → Email Accounts → for the mailbox click Connect Devices. It shows server, port and encryption. User is the full e-mail, password is the mailbox password.',
  'unchanged'=>'•••• unchanged',
  'th_home'=>'Home page sections','th_projects'=>'“Projects” section','th_services'=>'“Services” section','th_clients'=>'“Clients” section','th_cta'=>'Call to action (CTA)','th_desc'=>'Description','th_btn'=>'Button text',
  'ta_page'=>'“About” page','ta_lead'=>'Subtitle (under the heading)','ta_intro'=>'“Who we are” block','ta_mission'=>'Mission','ta_approach'=>'Approach','ta_stats'=>'Stats (numbers)','ta_num'=>'Number','ta_label'=>'Caption','ta_text'=>'Text',
  'n_pages'=>'Pages','pg_all'=>'All pages','pg_all_h'=>'Pick a page to edit its texts.','pg_col'=>'Page','pg_saved'=>'Page saved.','pg_hero_title'=>'Page heading (H1)','pg_subtitle'=>'Subtitle','pg_image'=>'Image',
  'pg_seo'=>'Page SEO','pg_seo_title'=>'Meta title','pg_seo_desc'=>'Meta description','pg_seo_h'=>'What Google shows in results. Empty — a default is used.','o_home_note'=>'Title and description of each page (incl. home) — in the “Pages” section.','pg_home'=>'Home','pg_about'=>'About','pg_projects'=>'Projects','pg_services'=>'Services','pg_clients'=>'Clients','pg_contact'=>'Contact','t_common_h'=>'Global texts: used in the footer, SEO and across the site.',
],
'az' => [
  'g_main'=>'ƏSAS','g_content'=>'MƏZMUN','g_settings'=>'AYARLAR',
  'n_dashboard'=>'İcmal','n_texts'=>'Sayt mətnləri','n_projects'=>'Layihələr','n_areas'=>'Fəaliyyət sahələri',
  'n_services'=>'Xidmətlər','n_clients'=>'Müştərilər','n_contacts'=>'Əlaqə və sosial','n_messages'=>'Müraciətlər',
  'n_seo'=>'SEO','n_mail'=>'Poçt (SMTP)','n_security'=>'Təhlükəsizlik','n_users'=>'İstifadəçilər','n_profile'=>'Profilim',
  'open_site'=>'Saytı aç','logout'=>'Çıxış','logged_as'=>'Daxil olmusunuz:','menu'=>'Menyu',
  'save'=>'Yadda saxla','save_all'=>'Hamısını saxla','add'=>'Əlavə et','delete'=>'Sil','edit'=>'Dəyiş',
  'back_list'=>'Siyahıya','show_site'=>'Saytda göstər','show'=>'Göstər','order'=>'Sıra','name'=>'Ad',
  'photo'=>'Şəkil','title_f'=>'Başlıq','desc_f'=>'Təsvir','saved'=>'Dəyişikliklər saxlanıldı.','deleted'=>'Silindi.',
  'login_title'=>'Panelə giriş','login_sub'=>'Sayt məzmununun idarəsi','email'=>'E-poçt','password'=>'Şifrə',
  'login_btn'=>'Daxil ol','login_bad'=>'E-poçt və ya şifrə yanlışdır. Qalan cəhd:','login_many'=>'Çox cəhd. 15 dəqiqədən sonra yenidən yoxlayın.','login_robot'=>'Robot olmadığınızı təsdiqləyin.',
  'login_id'=>'E-poçt və ya istifadəçi adı','login_forgot'=>'Şifrəni unutmusunuz?','show_pass'=>'Şifrəni göstər',
  'forgot_title'=>'Şifrənin bərpası','forgot_sub'=>'E-poçtunuzu yazın — sıfırlama linki göndərəcəyik.','forgot_email'=>'E-poçt','forgot_send'=>'Link göndər','forgot_sent'=>'Əgər belə e-poçt qeydiyyatdadırsa, sıfırlama linki göndərdik.','forgot_back'=>'Girişə qayıt',
  'reset_title'=>'Yeni şifrə','reset_new'=>'Yeni şifrə (min. 8 simvol)','reset_confirm'=>'Şifrəni təkrarlayın','reset_save'=>'Şifrəni saxla','reset_done'=>'Şifrə dəyişdirildi. Yeni şifrə ilə daxil olun.','reset_bad'=>'Link etibarsız və ya vaxtı keçib.','reset_mismatch'=>'Şifrələr uyğun gəlmir.','reset_short'=>'Ən azı 8 simvol.','reset_subj'=>'Şifrənin bərpası — MYBEL','reset_body'=>'Şifrəni sıfırlamaq üçün bu linkə keçin (1 saat etibarlıdır):',
  'd_projects'=>'layihə','d_areas'=>'fəaliyyət sahəsi','d_services'=>'xidmət','d_new'=>'yeni müraciət',
  'd_quick'=>'Sürətli əməliyyatlar','d_quick_h'=>'Adətən buradan başlayırlar.','d_addproj'=>'Layihə əlavə et','d_edittext'=>'Mətnləri redaktə et',
  'd_pub'=>'Dərc','d_pub_h'=>'Dəyişikliklər dərhal saxlanılır və sayt onları yenidən qurmadan göstərir.','d_home'=>'Ana səhifə','d_contacts'=>'Əlaqə',
  't_title'=>'Sayt mətnləri','t_common'=>'Ümumi','t_legal'=>'Hüquqi ad (futer)','t_slogan'=>'Şüar','t_shortdesc'=>'Qısa təsvir (futer / SEO ehtiyat)',
  't_hero'=>'Əsas ekran (Hero)','t_eyebrow'=>'Üst başlıq','t_hero_title'=>'Başlıq (sətir keçidi = yeni sətir)','t_hero_lead'=>'Alt başlıq',
  't_about'=>'“Şirkət haqqında” bloku (ana səhifə)','t_about_text'=>'Mətn (boş sətir = yeni abzas)','t_saved'=>'Mətnlər saxlanıldı. Sayt dərhal yenilənir.',
  't_video'=>'“Şirkət haqqında” səhifəsində video','t_video_h'=>'YouTube / Vimeo linki və ya birbaşa .mp4. Boş — saytda “video yeri” göstərilir.',
  'p_edit'=>'Layihəni redaktə et','p_new'=>'Yeni layihə','p_slug'=>'Slug (URL, istəyə görə)','p_slug_ph'=>'başlıqdan avtomatik',
  'p_cat'=>'Kateqoriya','p_loc'=>'Məkan','p_year'=>'İl','p_order_hint'=>'Sıra (kiçik = yuxarı)','p_excerpt'=>'Qısa təsvir (kartda)',
  'p_body'=>'Tam mətn','p_cover'=>'Örtük şəkli','p_or_url'=>'və ya keçid https://...','p_gallery'=>'Qalereya','p_remove'=>'sil','p_or_urls'=>'və ya boşluqla keçidlər',
  'p_all'=>'Bütün layihələr','p_all_h'=>'Sıra və görünmə hər layihənin kartında idarə olunur.','p_new_btn'=>'+ Yeni layihə','p_deleted'=>'Layihə silindi.','p_need_title'=>'Başlıq mütləqdir.','p_saved'=>'Layihə saxlanıldı.','p_confirm'=>'Layihə silinsin?','p_services'=>'Bu layihənin göstəriləcəyi xidmətlər','p_services_h'=>'Layihə seçilmiş xidmətlərin səhifəsində “Bağlı layihələr” bölməsində görünəcək.',
  'a_title'=>'Fəaliyyət sahələri','a_edit'=>'Sahəni redaktə et','a_new'=>'Yeni sahə','a_new_btn'=>'+ Yeni sahə','a_h'=>'Restoranlar, otellər, fərdi evlər və s.','a_deleted'=>'Sahə silindi.','a_saved'=>'Sahə saxlanıldı.','a_body'=>'Tam mətn (HTML olar)',
  's_title'=>'Xidmətlər','s_add'=>'Xidmət əlavə et','s_icon'=>'İkon','s_add_btn'=>'+ Əlavə et','s_all'=>'Bütün xidmətlər','s_added'=>'Xidmət əlavə olundu.','s_deleted'=>'Xidmət silindi.','s_saved'=>'Xidmət saxlanıldı.',
  's_new'=>'Yeni xidmət','s_edit'=>'Xidməti redaktə et','s_new_btn'=>'+ Yeni xidmət','s_all_h'=>'Hər xidmətin içində layihələri bağlamaq olar.','s_body'=>'Detal mətn (xidmət səhifəsi, HTML olar)','s_short'=>'Qısa təsvir (kartda)','s_link'=>'Bağlı layihələr','s_link_h'=>'Bu xidmətə aid layihələri seçin — onlar səhifəsində təsvirin altında görünəcək.','s_noproj'=>'Hələ layihə yoxdur — əvvəlcə layihə əlavə edin.',
  'ic_kitchen'=>'Mətbəx','ic_table'=>'Masa','ic_bed'=>'Çarpayı','ic_wardrobe'=>'Şkaf','ic_sofa'=>'Divan','ic_design'=>'Dizayn',
  'c_title'=>'Müştərilər','c_add'=>'Müştəri əlavə et','c_add_h'=>'Ən yaxşısı — şəffaf fonda loqo (PNG/SVG). 3 MB-a qədər.','c_link'=>'Keçid (istəyə görə)','c_logo_file'=>'Loqo faylı','c_logo_url'=>'və ya loqo keçidi','c_add_btn'=>'Müştəri əlavə et',
  'c_list'=>'Müştəri siyahısı','c_list_h'=>'Loqolar hərəkət edən lentdə göstərilir. Sıra rəqəmə görə.','c_logo'=>'Loqo','c_added'=>'Müştəri əlavə olundu.','c_deleted'=>'Müştəri silindi.','c_need'=>'Ad və ya loqo göstərin.',
  'k_title'=>'Əlaqə və sosial','k_on_site'=>'Saytda əlaqə','k_phone'=>'Telefon','k_addr'=>'Ünvan','k_hours'=>'İş saatları','k_map'=>'Xəritə (embed keçidi)',
  'k_social'=>'WhatsApp və sosial','k_social_h'=>'WhatsApp: yalnız rəqəmlər. Sosial: tam keçidlər (boşlar göstərilmir).','k_wa'=>'WhatsApp nömrəsi','k_saved'=>'Əlaqə saxlanıldı.',
  'o_title'=>'Axtarış optimizasiyası','o_h'=>'Keçid paylaşılanda Google və sosial şəbəkələr bunu görür.','o_mt'=>'Ana səhifə başlığı (Title, 50–60 simvol)','o_md'=>'Təsvir (Description, 140–160 simvol)',
  'o_og'=>'Sosial şəbəkə şəkli (1200×630)','o_or'=>'və ya keçid /assets/... yaxud https://...','o_vis'=>'Axtarışda görünmə','o_open'=>'Axtarış üçün açıq','o_closed'=>'Bağlı (noindex)','o_saved'=>'SEO saxlanıldı.',
  'o_keywords'=>'Açar sözlər','o_keywords_h'=>'Vergüllə. Google demək olar ki nəzərə almır, amma zərəri yoxdur.','o_images'=>'Şəkillər: sosial və favicon','o_favicon'=>'Favicon (tab ikonu)','o_biz'=>'Biznes (Schema.org)','o_biz_h'=>'Zəngin snippetlər və Google lokal axtarışı üçün.','o_orgtype'=>'Təşkilat növü','o_price'=>'Qiymət aralığı','o_analytics'=>'Analitika və təsdiq','o_ga'=>'Google Analytics (GA4)','o_ga_h'=>'GA4 hesabınızdan G-XXXXXXXXXX formatında ID.','o_gsc'=>'Google Search Console — təsdiq kodu','o_gsc_h'=>'google-site-verification teqinin content dəyəri (HTML teq üsulu).',
  'm_title'=>'Müraciətlər','m_head'=>'Əlaqə formasından mesajlar','m_total'=>'Cəmi:','m_unread'=>'Oxunmamış:','m_readall'=>'Hamısını oxunmuş kimi işarələ','m_none'=>'Hələ müraciət yoxdur.',
  'm_new'=>'yeni','m_read'=>'Oxundu','m_unreadbtn'=>'Oxunmamışa','m_phone'=>'Tel:','m_readall_done'=>'Hamısı oxunmuş kimi işarələndi.','m_deleted'=>'Müraciət silindi.','m_confirm'=>'Müraciət silinsin?',
  'u_title'=>'İstifadəçilər','u_add'=>'İstifadəçi əlavə et','u_add_h'=>'“Administrator” — tam giriş. “Redaktor” — yalnız məzmun (istifadəçilərsiz).','u_pass8'=>'Şifrə (min. 8 simvol)','u_role'=>'Rol','u_editor'=>'Redaktor','u_admin'=>'Administrator',
  'u_all'=>'Bütün istifadəçilər','u_all_h'=>'Dəyişmək istəmirsinizsə, şifrə xanasını boş buraxın.','u_newpass'=>'Yeni şifrə','u_active'=>'Aktiv','u_login'=>'Giriş','u_you'=>'sizsiniz','u_save'=>'Dəyişiklikləri saxla',
  'u_bad'=>'Ad, düzgün e-poçt və şifrə (min. 8 simvol) daxil edin.','u_exists'=>'Bu e-poçtla istifadəçi artıq var.','u_added'=>'İstifadəçi əlavə olundu.','u_self'=>'Özünüzü silə bilməzsiniz.','u_deleted'=>'İstifadəçi silindi.','u_need_admin'=>'Ən azı bir aktiv administrator qalmalıdır.','u_confirm'=>'İstifadəçi silinsin?',
  'r_title'=>'Profilim','r_profile'=>'Profil','r_login'=>'E-poçt (giriş):','r_role'=>'rol:','r_chpass'=>'Şifrə dəyişmə','r_chpass_h'=>'Yalnız şifrəni dəyişmək istəsəniz doldurun.','r_cur'=>'Cari şifrə','r_new'=>'Yeni şifrə','r_rep'=>'Təkrar',
  'r_bad_cur'=>'Cari şifrə yanlışdır.','r_short'=>'Yeni şifrə — ən azı 8 simvol.','r_nomatch'=>'Şifrələr uyğun gəlmir.','r_saved'=>'Profil yeniləndi.',
  'x_title'=>'Cloudflare Turnstile (kapça)','x_on'=>'aktiv','x_off'=>'deaktiv','x_h'=>'Panelə girişi və sayt formasını botlardan qoruyur. Pulsuz, şəkil tapmacası yoxdur.','x_enable'=>'Turnstile-i aktiv et','x_site'=>'Site Key (açıq açar)','x_secret'=>'Secret Key (gizli açar)','x_unchanged'=>'•••• dəyişmədən','x_saved'=>'Təhlükəsizlik ayarları saxlanıldı.',
  'x_where'=>'Açarları haradan almalı','x_w1'=>'dash.cloudflare.com → Turnstile bölməsinə keçin.','x_w2'=>'Add widget düyməsini basın. Domain — mybel.az (və www.mybel.az).','x_w3'=>'Widget Mode — Managed.','x_w4'=>'Site Key və Secret Key-i yuxarıdakı xanalara köçürün və qeyd qutusunu aktiv edin.',
  'x_prot'=>'Artıq qorunur','x_p1'=>'Şifrələr geri qaytarılmayan hash (bcrypt) kimi saxlanılır.','x_p2'=>'Bütün formalar CSRF-dən qorunur.','x_p3'=>'Giriş limiti: bir IP-dən 15 dəqiqədə 10 cəhd.','x_p4'=>'Formalarda gizli bot tələsi (honeypot).','x_p5'=>'Məlumat qovluqları vebdən bağlıdır; yükləmələrdə PHP icrası qadağandır.',
  'l_title'=>'SMTP ayarları','l_h'=>'SMTP ilə məktublar server funksiyasından etibarlı çatır. Boş buraxsanız — mail() istifadə olunur.','l_host'=>'SMTP server','l_port'=>'Port','l_enc'=>'Şifrələmə','l_tls'=>'STARTTLS (587)','l_ssl'=>'SSL/TLS (465)','l_none'=>'Şifrələmə yoxdur',
  'l_user'=>'İstifadəçi (adətən tam e-poçt)','l_from'=>'Göndərən ünvanı (From)','l_fromname'=>'Göndərən adı','l_saved'=>'SMTP ayarları saxlanıldı.',
  'l_test'=>'Göndərmə yoxlaması','l_test_h'=>'Ayarların doğru olduğunu yoxlamaq üçün test məktub göndərəcəyik. Əvvəlcə ayarları saxlayın.','l_to'=>'Alıcı ünvanı','l_send'=>'Test göndər','l_bad_to'=>'Düzgün alıcı e-poçtu daxil edin.','l_sent'=>'Məktub göndərildi:','l_err'=>'Xəta:',
  'l_where'=>'Məlumatı haradan almalı','l_where_h'=>'cPanel → Email Accounts → lazımi qutuda Connect Devices basın. Orada server, port və şifrələmə göstərilir. İstifadəçi — tam e-poçt, şifrə — bu qutunun şifrəsidir.',
  'unchanged'=>'•••• dəyişmədən',
  'th_home'=>'Ana səhifə bölmələri','th_projects'=>'“Layihələr” bölməsi','th_services'=>'“Xidmətlər” bölməsi','th_clients'=>'“Müştərilər” bölməsi','th_cta'=>'Çağırış (CTA)','th_desc'=>'Təsvir','th_btn'=>'Düymə mətni',
  'ta_page'=>'“Şirkət haqqında” səhifəsi','ta_lead'=>'Alt başlıq (başlığın altında)','ta_intro'=>'“Kimik biz” bloku','ta_mission'=>'Missiya','ta_approach'=>'Yanaşma','ta_stats'=>'Rəqəmlər (statistika)','ta_num'=>'Rəqəm','ta_label'=>'Yazı','ta_text'=>'Mətn',
  'n_pages'=>'Səhifələr','pg_all'=>'Bütün səhifələr','pg_all_h'=>'Mətnlərini redaktə etmək üçün səhifə seçin.','pg_col'=>'Səhifə','pg_saved'=>'Səhifə saxlanıldı.','pg_hero_title'=>'Səhifə başlığı (H1)','pg_subtitle'=>'Alt başlıq','pg_image'=>'Şəkil',
  'pg_seo'=>'Səhifə SEO','pg_seo_title'=>'Meta başlıq (Title)','pg_seo_desc'=>'Meta təsvir (Description)','pg_seo_h'=>'Google nəticələrdə göstərir. Boş — standart istifadə olunur.','o_home_note'=>'Hər səhifənin (ana səhifə daxil) başlıq və təsviri “Səhifələr” bölməsindədir.','pg_home'=>'Ana səhifə','pg_about'=>'Şirkət haqqında','pg_projects'=>'Layihələr','pg_services'=>'Xidmətlər','pg_clients'=>'Müştərilər','pg_contact'=>'Əlaqə','t_common_h'=>'Qlobal mətnlər: futer, SEO və bütün saytda istifadə olunur.',
],
];
