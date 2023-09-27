<?php

$entry = array(
    'form_id' => 1,
    '1' => $_POST['your-name'],
    '2' => $_POST['your-email'],
    '3' => $_POST['your-phone'],
    '4' => $_POST['your-questions']
);

$query = 'select * from ' . $wpdb->prefix . 'rg_form_meta where form_id="1"';
$row = $wpdb->get_row($query);

$decoded = json_decode($row->confirmations);
$notification = '';
foreach ($decoded as $dec) {
    $notification = $dec->message;
}

$entry_id = GFAPI::add_entry($entry);



send_notifications(1, $entry_id);



FrmEntry::create(array(
        'form_id' => 2,
        'item_meta' => array(
            8 => $_POST['dropdown'],
            9 => $_POST['betreff'],
            10 => $_POST['mitteilung'],
            11 => $_POST['form_sex'],
            12 => $_POST['titel'],
            13 => $_POST['vorname'],
            14 => $_POST['name'],
            15 => $_POST['firma'],
            16 => $_POST['form_email'],
            17 => $_POST['plz'],
            18 => $_POST['ort'],
            
            
        )
    ));

echo getFormidableFormNotification(3);




try {

        require_once dirname(__FILE__).'/Mailchimp.php';
        $MailChimp = new Mailchimp('0bf6f512f66950e664beba771a1cf7fa-us4');


        $result = $MailChimp->call('lists/subscribe', array(
            'id' => '34cbe36cf7',
            'email' => array('email' => $_POST['email']),
            'merge_vars' => array(
                'MERGE2' => $_POST['name']
            ),
            'double_optin' => false,
            'update_existing' => true,
            'replace_interests' => false
        ));
    } catch (Exception $ex) {
        
    }

?>
<div id="map"></div>
<?php
$pom = get_field('position_on_map', getSettingsPageId());
if (isset($pom['lat'])):
    ?>
    <input type="hidden" id="lat" value="<?php echo $pom['lat'] ?>" />
    <input type="hidden" id="lng" value="<?php echo $pom['lng'] ?>" />
<?php endif ?>