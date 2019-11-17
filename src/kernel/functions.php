<?php

defined('PATH') or die('Please contact service.');
// Global functions
use DebugBar\StandardDebugBar;
use Symfony\Component\Dotenv\Dotenv;
use Twig\Environment as TwigInstance;
use Twig\Loader\FilesystemLoader;


CONST DS = DIRECTORY_SEPARATOR;
@$GLOBALS['debugbar'] = new StandardDebugBar;

function initEnvironmentConfig () {
    (new Dotenv)->load(dirname(dirname(__DIR__)) . DS . '.env');
    if (getenv('DEBUG') == 'true') {
        ini_set('display_errors', '1');
        error_reporting(E_ALL);
    }
}

function twigInstance () {
    $loader = new FilesystemLoader(PATH);
    $is_caching = [];
    if (getenv('TWIG_CACHING') == 'true') $is_caching = [
        'cache' => '../cache',
    ];

    return new TwigInstance($loader, $is_caching);
}


function render ($file, $data = []) {
    if (!file_exists(PATH . DS . cleanPath($file))) {
        print(twigInstance()->render(cleanPath('errors.404'), []));
        exit;
    }

    $file = viewChecker($file, $data);
    $out = twigInstance()->render(cleanPath($file), $data);
    print($out);
    exit;
}


function cleanPath ($view, $extension = '.html') {
    return str_replace('.', '/', $view) . $extension;
}


function viewChecker($file, $data) {
    if (empty($data['js']) && !in_array($file, ['errors.404'])) {
        $file = cleanPath($file);
        $out = twigInstance()->render(cleanPath('errors.404'), $data);
        print($out);
        exit;
    } 

    return $file;
}


function staticFiles ($files = [], $type = 'js') {
    $string = "";
    switch ($type) {
        case 'js':
            foreach ($files as $k => $file) {
                if (is_array($file) && !empty($file)) {
                    $string .= "<script src='" . $file['src'] . "'></script>";
                } else {
                    $string .= "<script src='js/" . $file . "'></script>";
                }
            };
            break;

        case 'css':
            foreach ($files as $k => $file) {
                if (is_array($file) && !empty($file)) {
                    $string .= "<link rel='stylesheet' href='" . $file['src'] . "'/>";
                } else {
                    $string .= "<link rel='stylesheet' href='css/" . $file . "'/>";
                }
            };
            break;
    }

    return $string ? $string : "";
}


function debugbar($msg = null, $type = 'messages') {
    if (getenv('DEBUG') == 'true') {
        $debugbarRenderer = $GLOBALS['debugbar']->getJavascriptRenderer();

        return [
            'head' => "
                <link rel=\"stylesheet\" type=\"text/css\" href=\"/css/debugbar/font-awesome.min.css\">
                <link rel=\"stylesheet\" type=\"text/css\" href=\"/css/debugbar/highlightjs/styles/github.css\">
                <link rel=\"stylesheet\" type=\"text/css\" href=\"/css/debugbar/debugbar.css\">
                <link rel=\"stylesheet\" type=\"text/css\" href=\"/css/debugbar/widgets.css\">
                <link rel=\"stylesheet\" type=\"text/css\" href=\"/css/debugbar/openhandler.css\">
                <script type=\"text/javascript\" src=\"/js/debugbar/jquery.min.js\"></script>
                <script type=\"text/javascript\" src=\"/js/debugbar/highlight.pack.js\"></script>
                <script type=\"text/javascript\" src=\"/js/debugbar/debugbar.js\"></script>
                <script type=\"text/javascript\" src=\"/js/debugbar/widgets.js\"></script>
                <script type=\"text/javascript\" src=\"/js/debugbar/openhandler.js\"></script>",
            'footer' => '<script type="text/javascript">
                        var phpdebugbar = new PhpDebugBar.DebugBar();
                        phpdebugbar.addIndicator("php_version", new PhpDebugBar.DebugBar.Indicator({"icon":"code","tooltip":"Version"}), "right");
                        phpdebugbar.addTab("messages", new PhpDebugBar.DebugBar.Tab({"icon":"list-alt","title":"Messages", "widget": new PhpDebugBar.Widgets.MessagesWidget()}));
                        phpdebugbar.addTab("request", new PhpDebugBar.DebugBar.Tab({"icon":"tags","title":"Request", "widget": new PhpDebugBar.Widgets.VariableListWidget()}));
                        phpdebugbar.addIndicator("time", new PhpDebugBar.DebugBar.Indicator({"icon":"clock-o","tooltip":"Request Duration"}), "right");
                        phpdebugbar.addTab("timeline", new PhpDebugBar.DebugBar.Tab({"icon":"tasks","title":"Timeline", "widget": new PhpDebugBar.Widgets.TimelineWidget()}));
                        phpdebugbar.addIndicator("memory", new PhpDebugBar.DebugBar.Indicator({"icon":"cogs","tooltip":"Memory Usage"}), "right");
                        phpdebugbar.addTab("exceptions", new PhpDebugBar.DebugBar.Tab({"icon":"bug","title":"Exceptions", "widget": new PhpDebugBar.Widgets.ExceptionsWidget()}));
                        phpdebugbar.setDataMap({
                        "php_version": ["php.version", ],
                        "messages": ["messages.messages", []],
                        "messages:badge": ["messages.count", null],
                        "request": ["request", {}],
                        "time": ["time.duration_str", \'0ms\'],
                        "timeline": ["time", {}],
                        "memory": ["memory.peak_usage_str", \'0B\'],
                        "exceptions": ["exceptions.exceptions", []],
                        "exceptions:badge": ["exceptions.count", null]
                        });
                        phpdebugbar.restoreState();
                        phpdebugbar.ajaxHandler = new PhpDebugBar.AjaxHandler(phpdebugbar, undefined, true);
                        if (jQuery) phpdebugbar.ajaxHandler.bindToJquery(jQuery);
                        phpdebugbar.addDataSet({"__meta":{"id":"X8471a8465ba70e447f4120c2a5a7c5d7","datetime":"2019-11-17 16:20:54","utime":1574007654.637987,"method":"GET","uri":"\/","ip":"10.19.3.25"},"php":{"version":"7.2.24","interface":"apache2handler"},"messages":{"count":1,"messages":[{"message":"{#30\n  +\"IU_IDX\": 12987\n  +\"IU_LEVEL\": 1\n  +\"IU_ID\": \"ruby2\"\n  +\"password\": \"$2y$10$FYzvFGinqWP5fFNSUxHAU.ZXYXZbMKbtxmuRgwKHaA3E44LJLS5ay\"\n  +\"IU_NICKNAME\": \"\ub8e8\ube44\ud14c\uc2a4\ud2b8\uacc4\uc8152\"\n  +\"IU_CASH\": 534698\n  +\"IU_MOBILE\": \"01099595959\"\n  +\"IU_EMAIL\": null\n  +\"IU_BANKNAME\": \"\uad6d\ubbfc\uc740\ud589\"\n  +\"IU_BANKNUM\": \"231531351531\"\n  +\"IU_BANKOWNER\": \"5315153153\"\n  +\"IU_REGDATE\": \"2019-05-20 16:37:53\"\n  +\"IU_STATUS\": 1\n  +\"IU_SITE\": \"RUBY\"\n  +\"IU_GRADE\": 1\n  +\"IU_PWCK\": 2\n  +\"IU_SMSCK\": 1\n  +\"IU_T_MONEY\": 0.0\n  +\"RECOM_ID\": \"coder01\"\n  +\"RECOM_NUM\": 0\n  +\"IU_CODES\": null\n  +\"IU_LOGINDATE\": \"2019-11-17 22:48:18\"\n  +\"IU_POINT\": 1828013\n  +\"IU_IP\": null\n  +\"IU_CHARGE\": 0.0\n  +\"IU_EXCHANGE\": 38980000.0\n  +\"IU_LOGIN_CNT\": 1975\n  +\"IU_MOONEY_PW\": null\n  +\"IU_GAME_VIEW\": null\n  +\"IU_MEMO\": null\n  +\"IU_CHECK\": null\n  +\"IU_M_CHECK\": 0\n  +\"IU_LOGOUT\": null\n  +\"IU_RECOM_OK\": 1\n  +\"RECOM_MEMO\": null\n  +\"IU_KA_CHECK\": 0\n  +\"IU_MEMO1\": null\n  +\"IU_SA_BET_AMOUNT\": 0\n  +\"IU_SA_BET_AMOUNT1\": 0\n  +\"IU_SA_BET_CNT\": 0\n  +\"IU_SA_BET_CNT1\": 0\n  +\"IU_HI_BET_AMOUNT\": 0\n  +\"IU_HI_BET_AMOUNT1\": 0\n  +\"IU_HI_BET_CNT\": 0\n  +\"IU_HI_BET_CNT1\": 0\n  +\"IU_POWER_BET_AMOUNT\": 0\n  +\"IU_POWER_BET_AMOUNT1\": 0\n  +\"IU_POWER_BET_CNT\": 0\n  +\"IU_POWER_BET_CNT1\": 0\n  +\"IU_RC_BET_AMOUNT\": 0\n  +\"IU_RC_BET_AMOUNT1\": 0\n  +\"IU_RC_BET_CNT\": 0\n  +\"IU_RC_BET_CNT1\": 0\n  +\"IU_HOMERUN_BET_AMOUNT\": 0\n  +\"IU_HOMERUN_BET_AMOUNT1\": 0\n  +\"IU_HOMERUN_BET_CNT\": 0\n  +\"IU_HOMERUN_BET_CNT1\": 0\n  +\"IU_DARIDARI_BET_AMOUNT\": 0\n  +\"IU_DARIDARI_BET_AMOUNT1\": 0\n  +\"IU_DARIDARI_BET_CNT\": 0\n  +\"IU_DARIDARI_BET_CNT1\": 0\n  +\"IU_MGMEVENODD_BET_AMOUNT\": 0\n  +\"IU_MGMEVENODD_BET_AMOUNT1\": 0\n  +\"IU_MGMEVENODD_BET_CNT\": 0\n  +\"IU_MGMEVENODD_BET_CNT1\": 0\n  +\"IU_MGMBACARA_BET_AMOUNT\": 0\n  +\"IU_MGMBACARA_BET_AMOUNT1\": 0\n  +\"IU_MGMBACARA_BET_CNT\": 0\n  +\"IU_MGMBACARA_BET_CNT1\": 0\n  +\"IU_RETURNGAME_BET_AMOUNT\": 0\n  +\"IU_RETURNGAME_BET_AMOUNT1\": 0\n  +\"IU_RETURNGAME_BET_CNT\": 0\n  +\"IU_RETURNGAME_BET_CNT1\": 0\n  +\"IU_SPIKE_BET_AMOUNT\": 0\n  +\"IU_SPIKE_BET_AMOUNT1\": 0\n  +\"IU_SPIKE_BET_CNT\": 0\n  +\"IU_SPIKE_BET_CNT1\": 0\n  +\"IU_GOLD_DRAGON_TIGER_BET_AMOUNT\": 0\n  +\"IU_GOLD_DRAGON_TIGER_BET_AMOUNT1\": 0\n  +\"IU_GOLD_DRAGON_TIGER_BET_CNT\": 0\n  +\"IU_GOLD_DRAGON_TIGER_BET_CNT1\": 0\n  +\"IU_GOLD_ODD_EVEN_BET_AMOUNT\": 0\n  +\"IU_GOLD_ODD_EVEN_BET_AMOUNT1\": 0\n  +\"IU_GOLD_ODD_EVEN_BET_CNT\": 0\n  +\"IU_GOLD_ODD_EVEN_BET_CNT1\": 0\n  +\"IU_GOLD_SUTDA_BET_AMOUNT\": 0\n  +\"IU_GOLD_SUTDA_BET_AMOUNT1\": 0\n  +\"IU_GOLD_SUTDA_BET_CNT\": 0\n  +\"IU_GOLD_SUTDA_BET_CNT1\": 0\n  +\"IU_BET_SINGLE\": 0\n  +\"IU_BET_SADARI\": 0\n  +\"IU_BET_POWERBALL\": 0\n  +\"IU_BET_HIGHLOW\": 0\n  +\"IU_BET_SNAIL\": 0\n  +\"IU_BET_HOMERUN\": 0\n  +\"IU_BET_DARIDARI\": 0\n  +\"IU_BET_REALTIME\": 0\n  +\"IU_BET_MGMEVENODD\": 0\n  +\"IU_BET_MGMBACARA\": 0\n  +\"IU_BET_RETURNGAME\": 0\n  +\"IU_BET_SPIKE\": 0\n  +\"IU_BET_GOLD_DRAGON_TIGER\": 0\n  +\"IU_BET_GOLD_ODD_EVEN\": 0\n  +\"IU_BET_GOLD_SUTDA\": 0\n  +\"Column 105\": 0\n  +\"RECOM_MEMO2\": null\n  +\"IU_LEVEL_AUTO\": 1\n  +\"remember_token\": \"BaMdiY6qgAebexZrApNjZ1q7c8vLPUghWow2yB0EmKXBuZRyh0Tudhyb8BcQ\"\n  +\"busta_code\": \"-\"\n  +\"busta_current_level\": \"silver\"\n  +\"IU_BET_MONITORING\": null\n  +\"IU_CHARGE_MONITORING\": null\n  +\"IU_PLAYER_MONITORING\": null\n  +\"IU_FIRST_CHARGE\": null\n  +\"IU_MEMBERSHIP_DROP\": null\n  +\"IU_RECOMMEND_DROPPINGS\": null\n  +\"IU_CAN_INVITE\": null\n  +\"IU_CHAT_ACCOUNT\": null\n  +\"IU_LIST_PERMISSION\": \"{\"single_folder\":\"1\",\"live\":\"1\",\"bacarrat\":\"1\",\"snail\":\"1\",\"busta\":\"1\",\"v_soccer\":\"1\",\"aristocrat\":\"1\",\"novomatic\":\"1\",\"galaxy_baccarat\":\"1\",\"hi_lo\":\"1\",\"roulette\":\"1\",\"power_ball\":\"1\",\"power_ladder\":\"1\",\"seotda\":\"1\",\"dice\":\"1\",\"coin\":\"1\"}\"\n  +\"IU_DISTRIBUTOR\": 1\n  +\"IU_SETTLEMENT\": null\n  +\"IU_LAST_UPDATE_BY\": \"admin\"\n  +\"IU_FIRST_CHARGE_NOT_GIVE\": null\n  +\"IU_LOSE_POINT_NOT_GIVE\": null\n  +\"IU_RECOMM_LOSE_POINT_NOT_GIVE\": null\n  +\"IU_CALL_CENTER_CALL_CHECK\": null\n  +\"SportSinglePenalty\": null\n  +\"TOKEN_UID\": null\n  +\"IU_DEPOSIT_ACC_CHECK_COUNT\": 3\n  +\"IU_LAST_ACC_CHECK_DATE\": \"2019-08-19 16:14:53\"\n  +\"IU_LAST_CHIPEXCHANGE_DATE\": \"2019-11-17 16:40:08\"\n  +\"IU_CALENDAR_STAMP\": 1\n  +\"IU_THEME\": \"light\"\n  +\"IU_THEMESETTINGS\": \"{\"theme\":\"light\",\"updated_to_light\":\"1\",\"updated_to_dark\":\"0\",\"is_manual\":\"1\",\"dont_ask\":\"1\",\"is_permanent\":\"0\",\"dont_ask_date\":\"Sun Nov 17 2019 23:46:34 +0900\",\"date_manual\":\"Sun Nov 17 2019 23:46:34 +0900\",\"last_changed\":\"Sun Nov 17 2019 23:46:34 +0900\"}\"\n  +\"IU_WITHDRAWAL_BONUS\": 1\n  +\"IU_LASTWBRESET\": \"2019-10-14 21:47:55\"\n  +\"IU_WbResetAmount\": 0\n  +\"IU_WbAllow\": 1\n  +\"IU_BS_Switch\": 1\n  +\"IU_COIN_GAME\": 1\n  +\"IU_AG_DONE\": 0\n  +\"IU_MG_DONE\": 0\n  +\"IU_TG_DONE\": 0\n}","message_html":null,"is_string":false,"label":"info","time":1574007654.636973}]},"request":{"$_GET":"[]","$_POST":"[]","$_COOKIE":"array:2 [\n  \"user\" => \"John Doe\"\n  \"controller\" => \"App\\Controllers\\HomeController\"\n]","$_SERVER":"array:45 [\n  \"UNIQUE_ID\" => \"XdFzZslNMtZqF37blYN53AAAAAE\"\n  \"HTTP_HOST\" => \"www.local.custom.com\"\n  \"HTTP_CONNECTION\" => \"keep-alive\"\n  \"HTTP_CACHE_CONTROL\" => \"max-age=0\"\n  \"HTTP_UPGRADE_INSECURE_REQUESTS\" => \"1\"\n  \"HTTP_USER_AGENT\" => \"Mozilla\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/78.0.3904.97 Safari\/537.36\"\n  \"HTTP_ACCEPT\" => \"text\/html,application\/xhtml+xml,application\/xml;q=0.9,image\/webp,image\/apng,*\/*;q=0.8,application\/signed-exchange;v=b3\"\n  \"HTTP_ACCEPT_ENCODING\" => \"gzip, deflate\"\n  \"HTTP_ACCEPT_LANGUAGE\" => \"en-US,en;q=0.9\"\n  \"HTTP_COOKIE\" => \"user=John+Doe; controller=App%5CControllers%5CHomeController\"\n  \"PATH\" => \"\/usr\/local\/sbin:\/usr\/local\/bin:\/usr\/sbin:\/usr\/bin\"\n  \"SERVER_SIGNATURE\" => \"\"\n  \"SERVER_SOFTWARE\" => \"Apache\/2.4.6 (CentOS) OpenSSL\/1.0.2k-fips mod_fcgid\/2.3.9 PHP\/7.2.24\"\n  \"SERVER_NAME\" => \"www.local.custom.com\"\n  \"SERVER_ADDR\" => \"10.19.3.207\"\n  \"SERVER_PORT\" => \"80\"\n  \"REMOTE_ADDR\" => \"10.19.3.25\"\n  \"DOCUMENT_ROOT\" => \"\/var\/www\/html\/custom-app\/public\"\n  \"REQUEST_SCHEME\" => \"http\"\n  \"CONTEXT_PREFIX\" => \"\"\n  \"CONTEXT_DOCUMENT_ROOT\" => \"\/var\/www\/html\/custom-app\/public\"\n  \"SERVER_ADMIN\" => \"webmaster@local.com\"\n  \"SCRIPT_FILENAME\" => \"\/var\/www\/html\/custom-app\/public\/index.php\"\n  \"REMOTE_PORT\" => \"64509\"\n  \"GATEWAY_INTERFACE\" => \"CGI\/1.1\"\n  \"SERVER_PROTOCOL\" => \"HTTP\/1.1\"\n  \"REQUEST_METHOD\" => \"GET\"\n  \"QUERY_STRING\" => \"\"\n  \"REQUEST_URI\" => \"\/\"\n  \"SCRIPT_NAME\" => \"\/index.php\"\n  \"PHP_SELF\" => \"\/index.php\"\n  \"REQUEST_TIME_FLOAT\" => 1574007654.61\n  \"REQUEST_TIME\" => 1574007654\n  \"DB_DRIVER\" => \"mysql\"\n  \"DB_HOST\" => \"10.19.3.185\"\n  \"DB_NAME\" => \"r444_ruby\"\n  \"DB_USER\" => \"onin_dev\"\n  \"DB_PASS\" => \"onin_dev\"\n  \"DB_CHARSET\" => \"utf8\"\n  \"DB_COLLATION\" => \"utf8_general_ci\"\n  \"DB_FREFIX\" => \"\"\n  \"TWIG_CACHING\" => \"false\"\n  \"DEBUG\" => \"true\"\n  \"TIMEZONE\" => \"Asia\/Manila\"\n  \"SYMFONY_DOTENV_VARS\" => \"DB_DRIVER,DB_HOST,DB_NAME,DB_USER,DB_PASS,DB_CHARSET,DB_COLLATION,DB_FREFIX,TWIG_CACHING,DEBUG,TIMEZONE\"\n]"},"time":{"start":1574007654.61,"end":1574007654.638524,"duration":0.028524160385131836,"duration_str":"28.52ms","measures":[{"label":"operations","start":1574007654.62529,"relative_start":0.015290021896362305,"end":1574007654.633044,"relative_end":1574007654.633044,"duration":0.007754087448120117,"duration_str":"7.75ms","params":[],"collector":null}]},"memory":{"peak_usage":1349480,"peak_usage_str":"1.29MB"},"exceptions":{"count":0,"exceptions":[]}}, "X8471a8465ba70e447f4120c2a5a7c5d7");
                        </script>'
        ];
    } else {
        return [];
    }
}
