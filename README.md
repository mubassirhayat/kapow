##kapow
WordPress theme framework for developers

---

###kapow installation
* download the latest version of kapow, unzip and move the content within your theme folder.
* open your functions.php file, and include the kapow bootstrap, as follows: `include dirname( __FILE__ ) . '/kapow/core/bootstrap.php';`

####Configuration
[how to configure kapow]

####Menus
Define your themes menus in "kapow/menus.php" file by adding a key/value pair at the array.

####Sidebars
Define your sidebars in "kapow/sidebars.php" by adding all the wp required array values.
e.g.:

```php
return array(
    array(
        'name'         => __( 'Menu top-right' ),
        'id'           => 'top-right-sidebar',
        'description'  => __( 'Widgets in this area will be shown on the right-hand side of menu.' ),
        'before_title' => '',
        'after_title'  => '',
        'before_title' => '',
        'after_title'  => '',
    ),
    [... more sidebars ...]
):
```

####Permalinks
[how to create custom permalinks rules description]

####Theme support
[theme supports description]

####Theme sizes
[theme sizes description]

---

###Helpers

####Add body classes
[how to add body classes, follows example]
`$app->addBodyClass( 'full-height' );`

####Add JavaScript files
[how to add JavaScript files, follows example]
`$app->addScript( 'jquery.js', KPHelper::kScriptPositionFoot, KPHelper::kAddMethodBefore );`

####Add Stylesheets
[how to add stylesheets, follows example]
`$app->addStylesheet( 'full-height' );`

####Add dynamic JavaScript Variables
[why and how to add JavaScript variables to <head> tag]
`$app->addJavascriptVariable( 'GLOVAL_JS_VAR', time() );`

####Wordpress menu classes manipulation
[why and how to add custom classes to wordpress menu items]

####Send e-mails
[how to send emails description, follows demo]
```php
$mail = KPMail::init();

$mail->setFrom( 'sender@example.com' );
$mail->setTo( 'some@mail.com' );
$mail->setSubject( 'Some nice subject message' );
$mail->setMailFooterMessage( '© footer line' );
$mail->setHelpMessage( 'Below some user informations:' );
$mail->setMailData( $_POST['contact'] );
$mail->setMailDataLabels( array( 
    'country'   => 'Country',
    'name'      => 'Firstname',
    'lastname'  => 'Lastname',
    'company'   => 'Company',
    'address'   => 'Address',
    'telephone' => 'Telephone',
    'email'     => 'Email',
    'message'   => 'Message'
) );

// Boom!
$mail->send();
```

---

###ToDo
* Page keywords
* Public addKeyword method
* Page description
* Public changeDescription method