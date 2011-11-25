<?php
$user = $vars['entity'];
/* @TODO
 - locale (à partir langue choisie par l'user ?)
 - pays et code pays
 - partie demographics en entier
 - la suite...

Valeurs à créer :
- country
- birthdate
*/

// Pour déterminer les préférences.. @todo
$count_workexperiences = count_user_objects($user->guid, "workexperience");
$count_educations = count_user_objects($user->guid, "education");
$count_languages = count_user_objects($user->guid, "language");
$count_foreign = count(get_user_objects_by_metadata($user->guid, "language", array('langtype'=>"foreign"), 99, 0));
$count_mother = $count_languages - $count_foreign;
?>
  
  <docinfo>
		<issuedate><?php echo date('c'); ?></issuedate>
		<xsdversion>V2.0</xsdversion>
		<comment>CV Europass généré par FormaVia à partir du profil personnel</comment>
	</docinfo>
	<prefs>
    <?php // Il va falloir une page pour régler ces préférences, si elles sont vraiment nécessaires ? .. ?>
    <field name="step1.lastName" before="step1.firstName" />
    <field name="step1.addressInfo" keep="true" />
    <field name="step1.telephone" keep="true" />
    <field name="step1.mobile" keep="true" />
    <field name="step1.fax" keep="true" />
    <field name="step1.email" keep="true" />
    <field name="step1.nationality" keep="true" />
    <field name="step1.birthDate" keep="true" format="/text/long" />
    <field name="step1.gender" keep="true" />
    <field name="step1.photo" keep="true" />
    <field name="step1.application.label" keep="true" />
    <field name="step3List" keep="true" before="step4List"/>
      <?php
      for ($i=0; $i<$count_workexperiences; $i++) {
        echo '
      <field name="step3List[' . $i . '].period" format="/text/long" />
      <field name="step3List[' . $i . '].position.label" keep="true" />
      <field name="step3List[' . $i . '].activities" keep="true" />
      <field name="step3List[' . $i . '].company.name" keep="true" />
      <field name="step3List[' . $i . '].company.addressInfo" keep="true" />
      <field name="step3List[' . $i . '].company.sector.label" keep="true" />
        ';
      }
      ?>
    <field name="step4List" keep="true" />
      <?php
      for ($i=0; $i<$count_educations; $i++) {
        echo '
      <field name="step4List[' . $i . '].period" format="/text/long" />
      <field name="step4List[' . $i . '].title" keep="true" />
      <field name="step4List[' . $i . '].skills" keep="true" />
      <field name="step4List[' . $i . '].educationalOrg.name" keep="true" />
      <field name="step4List[' . $i . '].educationalOrg.addressInfo" keep="true" />
      <field name="step4List[' . $i . '].level.label" keep="true" />
        ';
      }
      ?>
    <field name="step5.motherLanguages" keep="true" />
    <field name="step5.foreignLanguageList" keep="true" />
      <?php
      for ($i=0; $i<$count_foreign; $i++) {
        echo '
      <field name="step5.foreignLanguageList[' . $i . ']"  keep="true" />
        ';
      }
      ?>
    <field name="step6.socialSkills" keep="true" />
    <field name="step6.organisationalSkills" keep="true" />
    <field name="step6.technicalSkills" keep="true" />
    <field name="step6.computerSkills" keep="true" />
    <field name="step6.artisticSkills" keep="true" />
    <field name="step6.otherSkills" keep="true" />
    <field name="step6.drivingLicences" keep="true" />
    <field name="step7.additionalInfo" keep="true" />
    <field name="step7.annexes" keep="true" />
    <field name="grid" keep="false" />
  </prefs>
  
	<identification>
		<firstname><?php echo $user->firstname; ?></firstname>
		<lastname><?php echo $user->lastname; ?></lastname>
		<contactinfo>
      <address>
        <addressLine><?php echo $user->address; ?></addressLine>
        <municipality><?php echo $user->city; ?></municipality>
        <postalCode><?php echo $user->postalcode; ?></postalCode>
        <country>
            <code><?php /* FR */ ?></code>
          <label><?php /* France */ ?></label>
        </country>
      </address>
			<telephone><?php echo $user->phone; ?></telephone>
			<fax><?php echo $user->fax; ?></fax>
			<mobile><?php echo $user->mobile; ?></mobile>
			<email><?php echo $user->contactemail; ?></email>
		</contactinfo>
		<demographics>
      <birthdate><?php /* AAAA-MM-DD */ ?></birthdate>
      <gender><?php /* M or F or else/undefined ? */ ?></gender>
      <nationality>
        <code><?php /* FR */ ?></code>
        <label><?php /* Française */ ?></label>
      </nationality>
    </demographics>
    <photo type="<?php /*Type de format, par ex.: JPEG */ ?>"><?php /* image encodée.. */ ?></photo>
  </identification>
	
	<application>
    <label><?php /* Intitulé recherche de poste*/ ?></label>
  </application>
  
  <workexperiencelist>
    <?php
    $workexperiences = get_user_objects($user->guid, "workexperience", 99);
    foreach ($workexperiences as $ent) { echo elgg_view_entity($ent, false); }
    ?>
  </workexperiencelist>
  
  <educationlist>
    <?php
    $educations = get_user_objects($user->guid, "education", 99);
    foreach ($educations as $ent) { echo elgg_view_entity($ent, false); }
    ?>
  </educationlist>
  
	<languagelist>
    <?php
    $languages = get_user_objects($user->guid, "language", 99);
    foreach ($languages as $ent) { echo elgg_view_entity($ent, false); }
    ?>
	</languagelist>

	<skilllist>
		<skill type="social">
      <?php $skills = get_user_objects_by_metadata($user->guid, "skill", array('skilltype'=>"social"), 99, 0);
      foreach ($skills as $skill) { echo elgg_view_entity($skill, false); } ?>
    </skill>
		<skill type="organisational">
      <?php $skills = get_user_objects_by_metadata($user->guid, "skill", array('skilltype'=>"organisational"), 99, 0);
      foreach ($skills as $skill) { echo elgg_view_entity($skill, false); } ?>
		</skill>
		<skill type="technical">
      <?php $skills = get_user_objects_by_metadata($user->guid, "skill", array('skilltype'=>"technical"), 99, 0);
      foreach ($skills as $skill) { echo elgg_view_entity($skill, false); } ?>
		</skill>
		<skill type="computer">
      <?php $skills = get_user_objects_by_metadata($user->guid, "skill", array('skilltype'=>"computer"), 99, 0);
      foreach ($skills as $skill) { echo elgg_view_entity($skill, false); } ?>
		</skill>
		<skill type="artistic">
      <?php $skills = get_user_objects_by_metadata($user->guid, "skill", array('skilltype'=>"artistic"), 99, 0);
      foreach ($skills as $skill) { echo elgg_view_entity($skill, false); } ?>
		</skill>
		<skill type="other">
      <?php $skills = get_user_objects_by_metadata($user->guid, "skill", array('skilltype'=>"other"), 99, 0);
      foreach ($skills as $skill) { echo elgg_view_entity($skill, false); } ?>
		</skill>
		<structured-skill xsi:type="europass:driving">
      <?php $skills = get_user_objects_by_metadata($user->guid, "skill", array('skilltype'=>"driving"), 99, 0);
      foreach ($skills as $skill) { ?>
      <drivinglicence><?php echo $skill->skilltype; ?></drivinglicence>
      <?php } ?>
		</structured-skill>
	</skilllist>
	
	<misclist>
		<misc type="additional"><?php /* infos complémentaires */ ?></misc>
		<misc type="annexes"><?php /* annexes : sous quelle forme exacte ? */ ?></misc>
	</misclist>
	