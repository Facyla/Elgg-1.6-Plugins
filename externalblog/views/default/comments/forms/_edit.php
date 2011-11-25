<?php

$opencomments = find_plugin_settings('anonymous_comments');

$blackbloc      = $opencomments->blackbloc;
$blackbloc      = preg_replace('/\r\n|\r/', "\n", $blackbloc);
$blackip        = explode("\n",$blackbloc);


if ( in_array($_SERVER['REMOTE_ADDR'], $blackip )){
  return;
  exit;
}

extend_view('metatags',	'comments/metatags');

// if (isset($vars['entity']) && isloggedin()) {
if ( isset($vars['entity']) ) {

    $nb_min = 0;
    $nb_max = 9;
    $nb1 = mt_rand($nb_min,$nb_max);
    $nb2 = mt_rand($nb_min,$nb_max);
    //$res = $nb1 + $nb2;

    //$type_comment = 'generic_comment';

    $form_body_anonymous = '';

    //$opencomments = find_plugin_settings('anonymous_comments');

    if (!isloggedin() && $opencomments->comments_formedit_disabled !='yes' && get_context() != 'pages') {
        //$type_comment = 'anonymous_comment';

        $form_body_anonymous .= '<p style="float:left; margin-right:15px;">'.elgg_echo("nom") . ' *<br />'. elgg_view('input/text', array(
                'internalname' 	=> 'comment_anonymous_name',
                'value' 	=> 'invite',
                'class'         => 'required lettersonly',
                'js'            => ' maxlength="10"'
                )).'</p>';

        $form_body_anonymous .= '<p style="float:left; margin-right:15px;">'.elgg_echo("email"). '  *<br />'.elgg_view('input/text', array(
                'internalname' 	=> 'comment_anonymous_mail',
                'value' 	=> '',
                'class'         => 'required email'
                )).'</p>';

        $form_body_anonymous .= '<p style="float:left; margin-right:15px;">'.$nb1 . '+'. $nb2 . ' = ? *<br />' .elgg_view('input/text', array(
                'internalname' 	=> 'equ',
                'value' 	=> '',
                'class'         => 'required number'
                )). '</p>';

        $form_body_anonymous .= elgg_view('input/hidden', array(
                'internalname' 	=> 'nb1',
                'value' 	=> $nb1

        ));
        $form_body_anonymous .= elgg_view('input/hidden', array(
                'internalname' 	=> 'nb2',
                'value' 	=> $nb2

        ));
        $form_body_anonymous .= '<div class="clearfloat"></div>(*) champ obligatoire<br />';
    }

    if (isloggedin() OR $form_body_anonymous !='' ) {
        $form_body .= "<div class=\"contentWrapper\"><p class='longtext_editarea'><label>".elgg_echo("generic_comments:text")."</label><br />";
        $form_body .= $form_body_anonymous;
        $form_body .= elgg_view('input/longtext',array('internalname' => 'generic_comment', 'class'=>'no_mce')) . "</p>";
        $form_body .= "<p>" . elgg_view('input/hidden', array('internalname' => 'entity_guid', 'value' => $vars['entity']->getGUID()));
        $form_body .= elgg_view('input/submit', array('value' => elgg_echo("save"))) . "</p></div>";
        echo elgg_view('input/form', array('body' => $form_body, 'action' => "{$vars['url']}action/comments/add", 'internalid' => 'commentAnonymous'));
    }
}



