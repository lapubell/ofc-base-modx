<?php

// this assumes the repo is inside $httpdocs/assets/repo, adjust the path below if necessary
require_once '../../../config.core.php';
require_once MODX_CORE_PATH.'model/modx/modx.class.php';
$modx = new modX();
$modx->initialize('mgr');

echo "MODX username: ";
$handle = fopen('php://stdin', 'r');
$username = $modx->sanitizeString( fgets($handle) );

echo "MODX password: ";
$handle = fopen('php://stdin', 'r');
$password = $modx->sanitizeString( fgets($handle) );

// code grabbed from the genius Amit Patel:
// http://stackoverflow.com/questions/14005966/login-to-modx-from-external-other-server-revolution-2-2-5
if (!isset($modx->lexicon) || !is_object($modx->lexicon)) {
    $modx->getService('lexicon','modLexicon');
}

$modx->lexicon->load('login');

$loginContext= isset ($scriptProperties['login_context']) ? $scriptProperties['login_context'] :
$modx->context->get('key');

$addContexts= isset ($scriptProperties['add_contexts']) && !empty($scriptProperties['add_contexts']) ? explode(',', $scriptProperties['add_contexts']) : array();

$mgrEvents = ($loginContext == 'mgr');

$givenPassword = $password;

/** @var $user modUser */
$user= $modx->getObjectGraph('modUser', '{"Profile":{},"UserSettings":{}}', array ('modUser.username' => $username));

if (!$user) {
    $ru = $modx->invokeEvent("OnUserNotFound", array(
        'user' => &$user,
        'username' => $username,
        'password' => $password,
        'attributes' => array(
            'loginContext' => $loginContext,
        )
    ));

    if (!empty($ru)) {
        foreach ($ru as $obj) {
            if (is_object($obj) && $obj instanceof modUser) {
                $user = $obj;
                break;
            }
        }
    }

    if (!is_object($user) || !($user instanceof modUser)) {
        //echo "cant locate account";
        echo $modx->toJSON($modx->error->failure($modx->lexicon('login_cannot_locate_account')));
        exit;
    }
}

if (!$user->get('active')) {
    //echo "inactivated accout";
    echo $modx->toJSON($modx->error->failure($modx->lexicon('login_user_inactive')));
    exit;
}

if (!$user->passwordMatches($givenPassword)) {

    if (!array_key_exists('login_failed', $_SESSION)) {
        $_SESSION['login_failed'] = 0;
    }
    
    if ($_SESSION['login_failed'] == 0) {
        $flc = ((integer) $user->Profile->get('failedlogincount')) + 1;
        $user->Profile->set('failedlogincount', $flc);
        $user->Profile->save();
        $_SESSION['login_failed']++;
    } else {
        $_SESSION['login_failed'] = 0;
    }

    echo $modx->toJSON($modx->error->failure($modx->lexicon('login_username_password_incorrect')));
    exit;
}

$fullname =  $user->Profile->get('fullname');
echo '{"success":true,"message":"Welcome '.$fullname.'!"}';
$modx->initialize('mgr');



// CHUNKS /////////////////////////////////////////////////////////////
echo "\nCreating chunks:\n\n";
$modx->runProcessor('element/chunk/create',array(
   'name' => 'HTML Head',
   'static' => 1,
   'static_file' => 'assets/repo/chunks/HTML_head.tpl',
   'source' => 1,
));
echo "Created HTML Head\n";
$modx->runProcessor('element/chunk/create',array(
   'name' => 'HTML Foot',
   'static' => 1,
   'static_file' => 'assets/repo/chunks/HTML_foot.tpl',
   'source' => 1,
));
echo "Created HTML Foot\n";
$modx->runProcessor('element/chunk/create',array(
   'name' => 'Analytics',
   'static' => 1,
   'static_file' => 'assets/repo/chunks/Analytics.tpl',
   'source' => 1,
));
echo "Created Analytics\n";
$modx->runProcessor('element/chunk/create',array(
   'name' => 'Header',
   'static' => 1,
   'static_file' => 'assets/repo/chunks/Header.tpl',
   'source' => 1,
));
echo "Created Header\n";
$modx->runProcessor('element/chunk/create',array(
   'name' => 'Footer',
   'static' => 1,
   'static_file' => 'assets/repo/chunks/Footer.tpl',
   'source' => 1,
));
echo "Created Footer\n";
$modx->runProcessor('element/chunk/create',array(
   'name' => 'Slider Slide cycle2',
   'static' => 1,
   'static_file' => 'assets/repo/chunks/Slider_Slide_cycle2.tpl',
   'source' => 1,
));
echo "Created Cycle2 Slider Tpl\n";





// TEMPLATES /////////////////////////////////////////////////////////////
echo "\nCreating/Updating templates:\n\n";
$modx->runProcessor('element/template/update',array(
    'id' => 1,
    'templatename' => 'Home Page Template',
    'description' => 'Template for the home page',
    'content' => '',
    'static' => 1,
    'static_file' => 'assets/repo/templates/home.tpl',
    'source' => 1,
    'icon' => 'icon-home icon'
));
echo "Updated Home Page Template\n";
$modx->runProcessor('element/template/create',array(
    'templatename' => 'Standard Page Template',
    'description' => 'Template for all standard pages',
    'content' => '',
    'static' => 1,
    'static_file' => 'assets/repo/templates/standard.tpl',
    'source' => 1,
));
echo "Created Standard Page Template\n";





// SNIPPETS /////////////////////////////////////////////////////////////
echo "\nCreating snippets:\n\n";
$modx->runProcessor('element/snippet/create',array(
    'name' => 'year',
    'snippet' => '',
    'static' => 1,
    'static_file' => 'assets/repo/snippets/year.tpl',
    'source' => 1,
));
echo "Created year Snippet\n";

echo "\n";