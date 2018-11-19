<?php
/** Arabic (العربية)
 *
 * To improve a translation please visit https://translatewiki.net
 *
 * @ingroup Language
 * @file
 *
 */

$linkPrefixExtension = true;
$fallback8bitEncoding = 'windows-1256';

$rtl = true;

/**
 * A list of date format preference keys which can be selected in user
 * preferences. New preference keys can be added, provided they are supported
 * by the language class's timeanddate(). Only the 5 keys listed below are
 * supported by the wikitext converter (DateFormatter.php).
 *
 * The special key "default" is an alias for either dmy or mdy depending on
 * $wgAmericanDates
 */
$datePreferences = [
	'default',
	'mdy',
	'dmy',
	'ymd',
	'hijri',
	'ISO 8601',
	'jMY',
];

/**
 * The date format to use for generated dates in the user interface.
 * This may be one of the above date preferences, or the special value
 * "dmy or mdy", which uses mdy if $wgAmericanDates is true, and dmy
 * if $wgAmericanDates is false.
 */
$defaultDateFormat = 'dmy or mdy';

/**
 * Associative array mapping old numeric date formats, which may still be
 * stored in user preferences, to the new string formats.
 */
$datePreferenceMigrationMap = [
	'default',
	'mdy',
	'dmy',
	'ymd'
];

/**
 * These are formats for dates generated by MediaWiki (as opposed to the wikitext
 * DateFormatter). Documentation for the format string can be found in
 * Language.php, search for sprintfDate.
 *
 * This array is automatically inherited by all subclasses. Individual keys can be
 * overridden.
 */
$dateFormats = [
	'mdy time' => 'H:i',
	'mdy date' => 'xg j، Y', # Arabic comma
	'mdy both' => 'H:i، xg j، Y', # Arabic comma

	'dmy time' => 'H:i',
	'dmy date' => 'j xg Y',
	'dmy both' => 'H:i، j xg Y', # Arabic comma

	'ymd time' => 'H:i',
	'ymd date' => 'Y xg j',
	'ymd both' => 'H:i، Y xg j', # Arabic comma

	'hijri time' => 'H:i',
	'hijri date' => 'xmj xmF xmY',
	'hijri both' => 'H:i، xmj xmF xmY',

	'ISO 8601 time' => 'xnH:xni:xns',
	'ISO 8601 date' => 'xnY-xnm-xnd',
	'ISO 8601 both' => 'xnY-xnm-xnd"T"xnH:xni:xns',

	'jMY time' => 'H:i',
	'jMY date' => 'j M Y',
	'jMY both' => 'H:i، j M Y', # Arabic comma
];

$digitTransformTable = [
	'0' => '٠', # &#x0660;
	'1' => '١', # &#x0661;
	'2' => '٢', # &#x0662;
	'3' => '٣', # &#x0663;
	'4' => '٤', # &#x0664;
	'5' => '٥', # &#x0665;
	'6' => '٦', # &#x0666;
	'7' => '٧', # &#x0667;
	'8' => '٨', # &#x0668;
	'9' => '٩', # &#x0669;
	'.' => '٫', # &#x066b; wrong table ?
	',' => '٬', # &#x066c;
];

$namespaceNames = [
	NS_MEDIA            => 'ميديا',
	NS_SPECIAL          => 'خاص',
	NS_TALK             => 'نقاش',
	NS_USER             => 'مستخدم',
	NS_USER_TALK        => 'نقاش_المستخدم',
	NS_PROJECT_TALK     => 'نقاش_$1',
	NS_FILE             => 'ملف',
	NS_FILE_TALK        => 'نقاش_الملف',
	NS_MEDIAWIKI        => 'ميدياويكي',
	NS_MEDIAWIKI_TALK   => 'نقاش_ميدياويكي',
	NS_TEMPLATE         => 'قالب',
	NS_TEMPLATE_TALK    => 'نقاش_القالب',
	NS_HELP             => 'مساعدة',
	NS_HELP_TALK        => 'نقاش_المساعدة',
	NS_CATEGORY         => 'تصنيف',
	NS_CATEGORY_TALK    => 'نقاش_التصنيف',
];

$namespaceAliases = [
	'وسائط' => NS_MEDIA,
	'صورة' => NS_FILE,
	'نقاش_الصورة' => NS_FILE_TALK,
];

$namespaceGenderAliases = [
	NS_USER => [
		'male' => 'مستخدم',
		'female' => 'مستخدمة'
	],
	NS_USER_TALK => [
		'male' => 'نقاش_المستخدم',
		'female' => 'نقاش_المستخدمة'
	],
];

$magicWords = [
	'redirect'                  => [ '0', '#تحويل', '#REDIRECT' ],
	'notoc'                     => [ '0', '__لافهرس__', '__NOTOC__' ],
	'nogallery'                 => [ '0', '__لامعرض__', '__NOGALLERY__' ],
	'forcetoc'                  => [ '0', '__لصق_فهرس__', '__FORCETOC__' ],
	'toc'                       => [ '0', '__فهرس__', '__TOC__' ],
	'noeditsection'             => [ '0', '__لاتحريرقسم__', '__NOEDITSECTION__' ],
	'currentmonth'              => [ '1', 'شهر_حالي', 'شهر_حالي2', 'CURRENTMONTH', 'CURRENTMONTH2' ],
	'currentmonth1'             => [ '1', 'شهر_حالي1', 'CURRENTMONTH1' ],
	'currentmonthname'          => [ '1', 'اسم_الشهر_الحالي', 'CURRENTMONTHNAME' ],
	'currentmonthnamegen'       => [ '1', 'اسم_الشهر_الحالي_المولد', 'CURRENTMONTHNAMEGEN' ],
	'currentmonthabbrev'        => [ '1', 'اختصار_الشهر_الحالي', 'CURRENTMONTHABBREV' ],
	'currentday'                => [ '1', 'يوم_حالي', 'CURRENTDAY' ],
	'currentday2'               => [ '1', 'يوم_حالي2', 'CURRENTDAY2' ],
	'currentdayname'            => [ '1', 'اسم_اليوم_الحالي', 'CURRENTDAYNAME' ],
	'currentyear'               => [ '1', 'عام_حالي', 'CURRENTYEAR' ],
	'currenttime'               => [ '1', 'وقت_حالي', 'CURRENTTIME' ],
	'currenthour'               => [ '1', 'ساعة_حالية', 'CURRENTHOUR' ],
	'localmonth'                => [ '1', 'شهر_محلي', 'شهر_محلي2', 'LOCALMONTH', 'LOCALMONTH2' ],
	'localmonth1'               => [ '1', 'شهر_محلي1', 'LOCALMONTH1' ],
	'localmonthname'            => [ '1', 'اسم_الشهر_المحلي', 'LOCALMONTHNAME' ],
	'localmonthnamegen'         => [ '1', 'اسم_الشهر_المحلي_المولد', 'LOCALMONTHNAMEGEN' ],
	'localmonthabbrev'          => [ '1', 'اختصار_الشهر_المحلي', 'LOCALMONTHABBREV' ],
	'localday'                  => [ '1', 'يوم_محلي', 'LOCALDAY' ],
	'localday2'                 => [ '1', 'يوم_محلي2', 'LOCALDAY2' ],
	'localdayname'              => [ '1', 'اسم_اليوم_المحلي', 'LOCALDAYNAME' ],
	'localyear'                 => [ '1', 'عام_محلي', 'LOCALYEAR' ],
	'localtime'                 => [ '1', 'وقت_محلي', 'LOCALTIME' ],
	'localhour'                 => [ '1', 'ساعة_محلية', 'LOCALHOUR' ],
	'numberofpages'             => [ '1', 'عدد_الصفحات', 'NUMBEROFPAGES' ],
	'numberofarticles'          => [ '1', 'عدد_المقالات', 'NUMBEROFARTICLES' ],
	'numberoffiles'             => [ '1', 'عدد_الملفات', 'NUMBEROFFILES' ],
	'numberofusers'             => [ '1', 'عدد_المستخدمين', 'NUMBEROFUSERS' ],
	'numberofactiveusers'       => [ '1', 'عدد_المستخدمين_النشطين', 'NUMBEROFACTIVEUSERS' ],
	'numberofedits'             => [ '1', 'عدد_التعديلات', 'NUMBEROFEDITS' ],
	'pagename'                  => [ '1', 'اسم_الصفحة', 'PAGENAME' ],
	'pagenamee'                 => [ '1', 'عنوان_الصفحة', 'PAGENAMEE' ],
	'namespace'                 => [ '1', 'نطاق', 'NAMESPACE' ],
	'namespacee'                => [ '1', 'عنوان_نطاق', 'NAMESPACEE' ],
	'namespacenumber'           => [ '1', 'عدد_نطاق', 'NAMESPACENUMBER' ],
	'talkspace'                 => [ '1', 'نطاق_النقاش', 'TALKSPACE' ],
	'talkspacee'                => [ '1', 'عنوان_النقاش', 'TALKSPACEE' ],
	'subjectspace'              => [ '1', 'نطاق_الموضوع', 'نطاق_المقالة', 'SUBJECTSPACE', 'ARTICLESPACE' ],
	'subjectspacee'             => [ '1', 'عنوان_نطاق_الموضوع', 'عنوان_نطاق_المقالة', 'SUBJECTSPACEE', 'ARTICLESPACEE' ],
	'fullpagename'              => [ '1', 'اسم_الصفحة_الكامل', 'اسم_صفحة_كامل', 'اسم_كامل', 'FULLPAGENAME' ],
	'fullpagenamee'             => [ '1', 'عنوان_الصفحة_الكامل', 'عنوان_صفحة_كامل', 'FULLPAGENAMEE' ],
	'subpagename'               => [ '1', 'اسم_الصفحة_الفرعي', 'SUBPAGENAME' ],
	'subpagenamee'              => [ '1', 'عنوان_الصفحة_الفرعي', 'SUBPAGENAMEE' ],
	'rootpagename'              => [ '1', 'جذر_اسم_الصفحة', 'ROOTPAGENAME' ],
	'rootpagenamee'             => [ '1', 'عنوان_جذر_الصفحة', 'ROOTPAGENAMEE' ],
	'basepagename'              => [ '1', 'اسم_الصفحة_الأساسي', 'BASEPAGENAME' ],
	'basepagenamee'             => [ '1', 'عنوان_الصفحة_الأساسي', 'BASEPAGENAMEE' ],
	'talkpagename'              => [ '1', 'اسم_صفحة_النقاش', 'TALKPAGENAME' ],
	'talkpagenamee'             => [ '1', 'عنوان_صفحة_النقاش', 'TALKPAGENAMEE' ],
	'subjectpagename'           => [ '1', 'اسم_صفحة_الموضوع', 'اسم_صفحة_المقالة', 'SUBJECTPAGENAME', 'ARTICLEPAGENAME' ],
	'subjectpagenamee'          => [ '1', 'عنوان_صفحة_الموضوع', 'عنوان_صفحة_المقالة', 'SUBJECTPAGENAMEE', 'ARTICLEPAGENAMEE' ],
	'msg'                       => [ '0', 'رسالة:', 'MSG:' ],
	'subst'                     => [ '0', 'نسخ:', 'SUBST:' ],
	'safesubst'                 => [ '0', 'نسخ_آمن:', 'SAFESUBST:' ],
	'msgnw'                     => [ '0', 'رسالة_بدون_تهيئة:', 'MSGNW:' ],
	'img_thumbnail'             => [ '1', 'تصغير', 'thumb', 'thumbnail' ],
	'img_manualthumb'           => [ '1', 'تصغير=$1', 'مصغر=$1', 'thumbnail=$1', 'thumb=$1' ],
	'img_right'                 => [ '1', 'يمين', 'right' ],
	'img_left'                  => [ '1', 'يسار', 'left' ],
	'img_none'                  => [ '1', 'بدون', 'بلا', 'none' ],
	'img_width'                 => [ '1', '$1بك', '$1عن', '$1px' ],
	'img_center'                => [ '1', 'مركز', 'center', 'centre' ],
	'img_framed'                => [ '1', 'إطار', 'بإطار', 'frame', 'framed', 'enframed' ],
	'img_frameless'             => [ '1', 'لاإطار', 'frameless' ],
	'img_lang'                  => [ '1', 'لغة=$1', 'lang=$1' ],
	'img_page'                  => [ '1', 'صفحة=$1', 'صفحة_$1', 'page=$1', 'page $1' ],
	'img_upright'               => [ '1', 'معدول', 'معدول=$1', 'معدول_$1', 'upright', 'upright=$1', 'upright $1' ],
	'img_border'                => [ '1', 'حدود', 'border' ],
	'img_baseline'              => [ '1', 'خط_أساسي', 'baseline' ],
	'img_sub'                   => [ '1', 'فرعي', 'sub' ],
	'img_super'                 => [ '1', 'سوبر', 'سب', 'super', 'sup' ],
	'img_top'                   => [ '1', 'أعلى', 'top' ],
	'img_text_top'              => [ '1', 'نص_أعلى', 'text-top' ],
	'img_middle'                => [ '1', 'وسط', 'middle' ],
	'img_bottom'                => [ '1', 'أسفل', 'bottom' ],
	'img_text_bottom'           => [ '1', 'نص_أسفل', 'text-bottom' ],
	'img_link'                  => [ '1', 'وصلة=$1', 'رابط=$1', 'link=$1' ],
	'img_alt'                   => [ '1', 'بديل=$1', 'alt=$1' ],
	'img_class'                 => [ '1', 'رتبة=$1', 'class=$1' ],
	'int'                       => [ '0', 'محتوى:', 'INT:' ],
	'sitename'                  => [ '1', 'اسم_الموقع', 'SITENAME' ],
	'ns'                        => [ '0', 'نط:', 'NS:' ],
	'nse'                       => [ '0', 'نطم:', 'NSE:' ],
	'localurl'                  => [ '0', 'مسار_محلي:', 'LOCALURL:' ],
	'localurle'                 => [ '0', 'عنوان_المسار_المحلي:', 'LOCALURLE:' ],
	'articlepath'               => [ '0', 'مسار_المقالة', 'ARTICLEPATH' ],
	'pageid'                    => [ '0', 'رقم_صفحة', 'PAGEID' ],
	'server'                    => [ '0', 'خادم', 'SERVER' ],
	'servername'                => [ '0', 'اسم_الخادم', 'SERVERNAME' ],
	'scriptpath'                => [ '0', 'مسار_السكريبت', 'مسار_سكريبت', 'SCRIPTPATH' ],
	'stylepath'                 => [ '0', 'مسار_الهيئة', 'STYLEPATH' ],
	'grammar'                   => [ '0', 'قواعد_اللغة:', 'GRAMMAR:' ],
	'gender'                    => [ '0', 'نوع:', 'GENDER:' ],
	'bidi'                      => [ '0', 'ثا:', 'BIDI:' ],
	'notitleconvert'            => [ '0', '__لاتحويل_عنوان__', '__لاتع__', '__NOTITLECONVERT__', '__NOTC__' ],
	'nocontentconvert'          => [ '0', '__لاتحويل_محتوى__', '__لاتم__', '__NOCONTENTCONVERT__', '__NOCC__' ],
	'currentweek'               => [ '1', 'أسبوع_حالي', 'CURRENTWEEK' ],
	'currentdow'                => [ '1', 'يوم_حالي_مأ', 'CURRENTDOW' ],
	'localweek'                 => [ '1', 'أسبوع_محلي', 'LOCALWEEK' ],
	'localdow'                  => [ '1', 'يوم_محلي_مأ', 'LOCALDOW' ],
	'revisionid'                => [ '1', 'رقم_المراجعة', 'REVISIONID' ],
	'revisionday'               => [ '1', 'يوم_المراجعة', 'REVISIONDAY' ],
	'revisionday2'              => [ '1', 'يوم_المراجعة2', 'REVISIONDAY2' ],
	'revisionmonth'             => [ '1', 'شهر_المراجعة', 'REVISIONMONTH' ],
	'revisionmonth1'            => [ '1', 'شهر_المراجعة1', 'REVISIONMONTH1' ],
	'revisionyear'              => [ '1', 'عام_المراجعة', 'REVISIONYEAR' ],
	'revisiontimestamp'         => [ '1', 'طابع_وقت_المراجعة', 'REVISIONTIMESTAMP' ],
	'revisionuser'              => [ '1', 'مستخدم_المراجعة', 'REVISIONUSER' ],
	'revisionsize'              => [ '1', 'حجم_المراجعة', 'REVISIONSIZE' ],
	'plural'                    => [ '0', 'جمع:', 'PLURAL:' ],
	'fullurl'                   => [ '0', 'عنوان_كامل:', 'FULLURL:' ],
	'fullurle'                  => [ '0', 'مسار_كامل:', 'FULLURLE:' ],
	'canonicalurl'              => [ '0', 'عنوان_قاعدة:', 'CANONICALURL:' ],
	'canonicalurle'             => [ '0', 'مسار_قاعدة:', 'CANONICALURLE:' ],
	'lcfirst'                   => [ '0', 'عنوان_كبير:', 'LCFIRST:' ],
	'ucfirst'                   => [ '0', 'عنوان_صغير:', 'UCFIRST:' ],
	'lc'                        => [ '0', 'صغير:', 'LC:' ],
	'uc'                        => [ '0', 'كبير:', 'UC:' ],
	'raw'                       => [ '0', 'خام:', 'RAW:' ],
	'displaytitle'              => [ '1', 'عرض_العنوان', 'DISPLAYTITLE' ],
	'rawsuffix'                 => [ '1', 'أر', 'آر', 'R' ],
	'nocommafysuffix'           => [ '0', 'لا_سيب', 'NOSEP' ],
	'newsectionlink'            => [ '1', '__وصلة_قسم_جديد__', '__NEWSECTIONLINK__' ],
	'nonewsectionlink'          => [ '1', 'لا_وصلة_قسم_جديد__', '__NONEWSECTIONLINK__' ],
	'currentversion'            => [ '1', 'نسخة_حالية', 'CURRENTVERSION' ],
	'urlencode'                 => [ '0', 'كود_المسار:', 'URLENCODE:' ],
	'anchorencode'              => [ '0', 'كود_الأنكور', 'ANCHORENCODE' ],
	'currenttimestamp'          => [ '1', 'طابع_الوقت_الحالي', 'CURRENTTIMESTAMP' ],
	'localtimestamp'            => [ '1', 'طابع_الوقت_المحلي', 'LOCALTIMESTAMP' ],
	'directionmark'             => [ '1', 'علامة_الاتجاه', 'علامة_اتجاه', 'DIRECTIONMARK', 'DIRMARK' ],
	'language'                  => [ '0', '#لغة:', '#LANGUAGE:' ],
	'contentlanguage'           => [ '1', 'لغة_المحتوى', 'لغة_محتوى', 'CONTENTLANGUAGE', 'CONTENTLANG' ],
	'pagesinnamespace'          => [ '1', 'صفحات_في_نطاق:', 'صفحات_في_نط:', 'PAGESINNAMESPACE:', 'PAGESINNS:' ],
	'numberofadmins'            => [ '1', 'عدد_الإداريين', 'NUMBEROFADMINS' ],
	'formatnum'                 => [ '0', 'صيغة_رقم', 'FORMATNUM' ],
	'padleft'                   => [ '0', 'باد_يسار', 'PADLEFT' ],
	'padright'                  => [ '0', 'باد_يمين', 'PADRIGHT' ],
	'special'                   => [ '0', 'خاص', 'special' ],
	'speciale'                  => [ '0', 'عنوان_خاص', 'speciale' ],
	'defaultsort'               => [ '1', 'ترتيب_افتراضي:', 'مفتاح_ترتيب_افتراضي:', 'ترتيب_تصنيف_افتراضي:', 'ترتيب_غيابي:', 'DEFAULTSORT:', 'DEFAULTSORTKEY:', 'DEFAULTCATEGORYSORT:' ],
	'filepath'                  => [ '0', 'مسار_الملف:', 'FILEPATH:' ],
	'tag'                       => [ '0', 'وسم', 'tag' ],
	'hiddencat'                 => [ '1', '__تصنيف_مخفي__', '__HIDDENCAT__' ],
	'pagesincategory'           => [ '1', 'صفحات_في_التصنيف', 'صفحات_في_تصنيف', 'PAGESINCATEGORY', 'PAGESINCAT' ],
	'pagesize'                  => [ '1', 'حجم_الصفحة', 'PAGESIZE' ],
	'index'                     => [ '1', '__فهرسة__', '__INDEX__' ],
	'noindex'                   => [ '1', '__لافهرسة__', '__NOINDEX__' ],
	'numberingroup'             => [ '1', 'عدد_في_المجموعة', 'عدد_في_مجموعة', 'NUMBERINGROUP', 'NUMINGROUP' ],
	'staticredirect'            => [ '1', '__تحويلة_إستاتيكية__', '__تحويلة_ساكنة__', '__STATICREDIRECT__' ],
	'protectionlevel'           => [ '1', 'مستوى_الحماية', 'PROTECTIONLEVEL' ],
	'protectionexpiry'          => [ '1', 'انتهاء_الحماية', 'PROTECTIONEXPIRY' ],
	'cascadingsources'          => [ '1', 'مصادر_مضمنة', 'CASCADINGSOURCES' ],
	'formatdate'                => [ '0', 'تهيئة_التاريخ', 'تهيئة_تاريخ', 'formatdate', 'dateformat' ],
	'url_path'                  => [ '0', 'مسار', 'PATH' ],
	'url_wiki'                  => [ '0', 'ويكي', 'WIKI' ],
	'url_query'                 => [ '0', 'استعلام', 'QUERY' ],
	'defaultsort_noerror'       => [ '0', 'لاخطأ', 'noerror' ],
	'defaultsort_noreplace'     => [ '0', 'لاتستبدل', 'noreplace' ],
	'displaytitle_noerror'      => [ '0', 'لا_خطأ', 'noerror' ],
	'displaytitle_noreplace'    => [ '0', 'لااستبدال', 'noreplace' ],
	'pagesincategory_all'       => [ '0', 'كل', 'all' ],
	'pagesincategory_pages'     => [ '0', 'صفحات', 'pages' ],
	'pagesincategory_subcats'   => [ '0', 'تصنيفات_فرعية', 'subcats' ],
	'pagesincategory_files'     => [ '0', 'ملفات', 'files' ],
];

$specialPageAliases = [
	'Activeusers'               => [ 'مستخدمون_نشطون' ],
	'Allmessages'               => [ 'كل_الرسائل' ],
	'AllMyUploads'              => [ 'كل_ملفاتي' ],
	'Allpages'                  => [ 'كل_الصفحات' ],
	'ApiHelp'                   => [ 'مساعدة_إيه_بي_آي' ],
	'ApiSandbox'                => [ 'ملعب_إيه_بي_آي' ],
	'Ancientpages'              => [ 'صفحات_قديمة' ],
	'Badtitle'                  => [ 'عنوان_سيئ' ],
	'Blankpage'                 => [ 'صفحة_فارغة' ],
	'Block'                     => [ 'منع', 'منع_أيبي', 'منع_مستخدم' ],
	'Booksources'               => [ 'مصادر_كتاب' ],
	'BotPasswords'              => [ 'كلمات_سر_البوت' ],
	'BrokenRedirects'           => [ 'تحويلات_مكسورة' ],
	'Categories'                => [ 'تصنيفات' ],
	'ChangeContentModel'        => [ 'تغيير_موديل_المحتوى' ],
	'ChangeCredentials'         => [ 'تغيير_الاعتمادات' ],
	'ChangeEmail'               => [ 'تغيير_البريد' ],
	'ChangePassword'            => [ 'تغيير_كلمة_السر', 'ضبط_كلمة_السر' ],
	'ComparePages'              => [ 'مقارنة_الصفحات' ],
	'Confirmemail'              => [ 'تأكيد_البريد' ],
	'Contributions'             => [ 'مساهمات' ],
	'CreateAccount'             => [ 'إنشاء_حساب' ],
	'Deadendpages'              => [ 'صفحات_نهاية_مسدودة' ],
	'DeletedContributions'      => [ 'مساهمات_محذوفة' ],
	'Diff'                      => [ 'فرق' ],
	'DoubleRedirects'           => [ 'تحويلات_مزدوجة' ],
	'EditTags'                  => [ 'تعديل_الوسوم' ],
	'EditWatchlist'             => [ 'تعديل_قائمة_المراقبة' ],
	'Emailuser'                 => [ 'مراسلة_المستخدم' ],
	'ExpandTemplates'           => [ 'فرد_القوالب' ],
	'Export'                    => [ 'تصدير' ],
	'Fewestrevisions'           => [ 'الأقل_تعديلا' ],
	'FileDuplicateSearch'       => [ 'بحث_ملف_مكرر' ],
	'Filepath'                  => [ 'مسار_ملف' ],
	'Import'                    => [ 'استيراد' ],
	'Invalidateemail'           => [ 'تعطيل_البريد_الإلكتروني' ],
	'JavaScriptTest'            => [ 'اختبار_جافا_سكريبت' ],
	'BlockList'                 => [ 'قائمة_المنع', 'عرض_المنع', 'قائمة_منع_أيبي' ],
	'LinkSearch'                => [ 'بحث_الوصلات' ],
	'LinkAccounts'              => [ 'وصل_الحسابات' ],
	'Listadmins'                => [ 'عرض_الإداريين' ],
	'Listbots'                  => [ 'عرض_البوتات' ],
	'Listfiles'                 => [ 'عرض_الملفات', 'قائمة_الملفات', 'قائمة_الصور' ],
	'Listgrouprights'           => [ 'عرض_صلاحيات_المجموعات', 'صلاحيات_مجموعات_المستخدمين' ],
	'Listgrants'                => [ 'عرض_المنح' ],
	'Listredirects'             => [ 'عرض_التحويلات' ],
	'ListDuplicatedFiles'       => [ 'عرض_الملفات_المكررة', 'عرض_تكرار_الملفات' ],
	'Listusers'                 => [ 'عرض_المستخدمين', 'قائمة_المستخدمين' ],
	'Lockdb'                    => [ 'غلق_قب' ],
	'Log'                       => [ 'سجل', 'سجلات' ],
	'Lonelypages'               => [ 'صفحات_وحيدة', 'صفحات_يتيمة' ],
	'Longpages'                 => [ 'صفحات_طويلة' ],
	'MediaStatistics'           => [ 'إحصاءات_الميديا' ],
	'MergeHistory'              => [ 'دمج_التاريخ' ],
	'MIMEsearch'                => [ 'بحث_ميم' ],
	'Mostcategories'            => [ 'الأكثر_تصنيفا' ],
	'Mostimages'                => [ 'أكثر_الملفات_وصلا', 'أكثر_الملفات', 'أكثر_الصور' ],
	'Mostinterwikis'            => [ 'الأكثر_إنترويكي' ],
	'Mostlinked'                => [ 'أكثر_الصفحات_وصلا', 'الأكثر_وصلا' ],
	'Mostlinkedcategories'      => [ 'أكثر_التصنيفات_وصلا', 'أكثر_التصنيفات_استخداما' ],
	'Mostlinkedtemplates'       => [ 'أكثر_القوالب_وصلا', 'أكثر_القوالب_استخداما' ],
	'Mostrevisions'             => [ 'الأكثر_تعديلا' ],
	'Movepage'                  => [ 'نقل_صفحة' ],
	'Mycontributions'           => [ 'مساهماتي' ],
	'MyLanguage'                => [ 'لغتي' ],
	'Mypage'                    => [ 'صفحتي' ],
	'Mytalk'                    => [ 'نقاشي' ],
	'Myuploads'                 => [ 'رفوعاتي' ],
	'Newimages'                 => [ 'ملفات_جديدة', 'صور_جديدة' ],
	'Newpages'                  => [ 'صفحات_جديدة' ],
	'PagesWithProp'             => [ 'صفحات_بخاصية' ],
	'PageLanguage'              => [ 'لغة_الصفحة' ],
	'PasswordReset'             => [ 'إعادة_ضبط_كلمة_السر' ],
	'PermanentLink'             => [ 'وصلة_دائمة', 'رابط_دائم' ],
	'Preferences'               => [ 'تفضيلات' ],
	'Prefixindex'               => [ 'فهرس_بادئة' ],
	'Protectedpages'            => [ 'صفحات_محمية' ],
	'Protectedtitles'           => [ 'عناوين_محمية' ],
	'Randompage'                => [ 'عشوائي', 'صفحة_عشوائية' ],
	'RandomInCategory'          => [ 'عشوائي_في_تصنيف' ],
	'Randomredirect'            => [ 'تحويلة_عشوائية' ],
	'Randomrootpage'            => [ 'صفحة_جذر_عشوائية' ],
	'Recentchanges'             => [ 'أحدث_التغييرات' ],
	'Recentchangeslinked'       => [ 'أحدث_التغييرات_الموصولة', 'تغييرات_مرتبطة' ],
	'Redirect'                  => [ 'تحويل' ],
	'RemoveCredentials'         => [ 'إزالة_الاعتمادات' ],
	'ResetTokens'               => [ 'إعادة_ضبط_المفاتيح' ],
	'Revisiondelete'            => [ 'حذف_مراجعة', 'حذف_نسخة' ],
	'RunJobs'                   => [ 'تشغيل_الوظائف' ],
	'Search'                    => [ 'بحث' ],
	'Shortpages'                => [ 'صفحات_قصيرة' ],
	'Specialpages'              => [ 'صفحات_خاصة' ],
	'Statistics'                => [ 'إحصاءات' ],
	'Tags'                      => [ 'وسوم' ],
	'TrackingCategories'        => [ 'تصنيفات_التتبع' ],
	'Unblock'                   => [ 'رفع_منع' ],
	'Uncategorizedcategories'   => [ 'تصنيفات_غير_مصنفة' ],
	'Uncategorizedimages'       => [ 'ملفات_غير_مصنفة', 'صور_غير_مصنفة' ],
	'Uncategorizedpages'        => [ 'صفحات_غير_مصنفة' ],
	'Uncategorizedtemplates'    => [ 'قوالب_غير_مصنفة' ],
	'Undelete'                  => [ 'استرجاع' ],
	'UnlinkAccounts'            => [ 'فك_الحسابات' ],
	'Unlockdb'                  => [ 'فتح_قب' ],
	'Unusedcategories'          => [ 'تصنيفات_غير_مستخدمة' ],
	'Unusedimages'              => [ 'ملفات_غير_مستخدمة', 'صور_غير_مستخدمة' ],
	'Unusedtemplates'           => [ 'قوالب_غير_مستخدمة' ],
	'Unwatchedpages'            => [ 'صفحات_غير_مراقبة' ],
	'Upload'                    => [ 'رفع' ],
	'UploadStash'               => [ 'رفع_مخفي' ],
	'Userlogin'                 => [ 'دخول_المستخدم' ],
	'Userlogout'                => [ 'خروج_المستخدم' ],
	'Userrights'                => [ 'صلاحيات_المستخدم', 'ترقية_مدير_نظام', 'ترقية_بوت' ],
	'Version'                   => [ 'نسخة' ],
	'Wantedcategories'          => [ 'تصنيفات_مطلوبة' ],
	'Wantedfiles'               => [ 'ملفات_مطلوبة' ],
	'Wantedpages'               => [ 'صفحات_مطلوبة', 'وصلات_مكسورة' ],
	'Wantedtemplates'           => [ 'قوالب_مطلوبة' ],
	'Watchlist'                 => [ 'قائمة_المراقبة' ],
	'Whatlinkshere'             => [ 'ماذا_يصل_هنا' ],
	'Withoutinterwiki'          => [ 'بدون_إنترويكي' ],
];

/**
 * Regular expression matching the "link trail", e.g. "ed" in [[Toast]]ed, as
 * the first group, and the remainder of the string as the second group. Modified to match
 * Arabic trails too.
 */
$linkTrail = '/^([a-zء-ي]+)(.*)$/sDu';

$imageFiles = [
	'button-bold'     => 'ar/button_bold.png',
	'button-italic'   => 'ar/button_italic.png',
	'button-link'     => 'ar/button_link.png',
	'button-headline' => 'ar/button_headline.png',
	'button-nowiki'   => 'ar/button_nowiki.png',
];
