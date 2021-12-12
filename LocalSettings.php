<?php

// User permissions
$wgGroupPermissions['editor'] = $wgGroupPermissions['user'];
$wgGroupPermissions['user'] = $wgGroupPermissions['*'];
$wgGroupPermissions['*']['edit'] = false;

# Require email confirmation to edit
$wgEmailConfirmToEdit = true;

# Protect templates
$wgNamespaceProtection[NS_TEMPLATE] = ['editinterface'];

# Allow users to edit their User pages
$wgAvailableRights[] = 'editotherthanmyuserpage';
$wgGroupPermissions['sysop']['editotherthanmyuserpage'] = true;
$wgGroupPermissions['editor']['editotherthanmyuserpage'] = true;
$wgHooks['userCan'][] = function ( Title &$title, User &$user, $action, &$result ) {
        if ( !( $action == 'edit' || $action == 'move' ) ) {
                return true;
        }
        if ( !$user->isAllowed( 'editotherthanmyuserpage' ) ) {
                $userPageTitle = Title::makeTitle( NS_USER, $user->getName() );
                if ( !$title->equals( $userPageTitle ) ) {
                        $result = false;
                        return false;
                }
        }
};

# Allow posting to CommentStreams for regular users/editors with confirmed email
$wgAutopromote = [
        'emailconfirmed' => APCOND_EMAILCONFIRMED,
];

// General settings
$wgPFEnableStringFunctions = true;
$wgRestrictDisplayTitle = false;
$wgAllowSiteCSSOnRestrictedPages = true;

// Skin settings
$egChameleonAvailableLayoutFiles = [
	'standard'   => 'skins/chameleon/layouts/standard.xml',
	'navhead'    => 'skins/chameleon/layouts/navhead.xml',
	'fixedhead'  => 'skins/chameleon/layouts/fixedhead.xml',
	'stickyhead' => 'skins/chameleon/layouts/stickyhead.xml',
	'clean'      => 'skins/chameleon/layouts/clean.xml',
	'literary'   => 'extensions/wikivisor/skins/chameleon/layouts/wikicraft.xml',
];
$egChameleonLayoutFile = "$IP/extensions/wikivisor/skins/chameleon/layouts/wikicraft.xml";
$egChameleonExternalStyleVariables = [
	'container-max-widths' => '(sm: 540px, md: 768px, lg: 1105px, xl: 1440px)',
];
$egChameleonExternalStyleModules = [
       	"$IP/extensions/wikivisor/skins/chameleon/wikicraft.scss" => 'afterMain',
];
# $egScssCacheType = CACHE_NONE;

// Other resources
$wgHooks['BeforePageDisplay'] = function( $out, $skin ) {
     $code = <<<'START_END_MARKER'
<!-- favicons -->
<link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicons/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicons/favicon-16x16.png">
<link rel="manifest" href="/favicons/site.webmanifest">
<link rel="mask-icon" href="/favicons/safari-pinned-tab.svg" color="#5bbad5">
<link rel="shortcut icon" href="/favicons/favicon.ico">
<meta name="msapplication-TileColor" content="#ffc40d">
<meta name="msapplication-config" content="/favicons/browserconfig.xml">
<meta name="theme-color" content="#ffffff">
START_END_MARKER;
     $out->addHeadItem( 'head-tags-load', $code );
};

// WikiEditor 2017
$wgDefaultUserOptions['visualeditor-enable'] = 1;
$wgHiddenPrefs[] = 'visualeditor-enable';
# $wgVisualEditorUseSingleEditTab = true;

$wgVisualEditorEnableWikitext = true;
$wgDefaultUserOptions['visualeditor-newwikitext'] = 1;
$wgHiddenPrefs[] = 'visualeditor-newwikitext';

$wgVisualEditorEnableDiffPage = true;
$wgVisualEditorEnableVisualSectionEditing = true;
$wgVisualEditorEnableExperimentalCode = true;
$wgHiddenPrefs[] = 'visualeditor-betatempdisable';

$wgDefaultUserOptions['usecodemirror'] = 1;

// Extensions
enableSemantics( 'literarymines.org' );

wfLoadExtension( 'Arrays' );
wfLoadExtension( 'Cite' );
wfLoadExtension( 'CiteThisPage' );
wfLoadExtension( 'CodeEditor' );
wfLoadExtension( 'CodeMirror' );
wfLoadExtension( 'Gadgets' );
wfLoadExtension( 'Loops' );
wfLoadExtension( 'PageForms' );
wfLoadExtension( 'PageNotice' );
wfLoadExtension( 'SemanticACL' );
wfLoadExtension( 'SemanticResultFormats' );
wfLoadExtension( 'TemplateData' );
wfLoadExtension( 'Variables' );
wfLoadExtension( 'VisualEditor' );
wfLoadExtension( 'WikiEditor' );

require_once( "$IP/extensions/SemanticDrilldown/SemanticDrilldown.php" );

$wgShowExceptionDetails = true;

