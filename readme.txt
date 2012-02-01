=== Gravity Forms (nl) ===
Contributors: pronamic, remcotolsma
Tags: gravityforms, gravity, form, forms, gravity forms, translation, dutch, nl, nl_NL, user registration
Donate link: http://pronamic.eu/donate/?for=wp-plugin-gravityforms-nl&source=wp-plugin-readme-txt
Requires at least: 3.0
Tested up to: 3.3.1
Stable tag: 2.5.7
Text Domain: gravityforms-nl

This WordPress plugin extends the Gravity Forms plugin with the Dutch translation.

== Description ==

<strong>Gravity Forms</strong> 1.6.2.1.1 | 
<strong>User Registration Add-On</strong> 1.2.11 | 
<strong>Campaign Monitor Add-On</strong> 1.9 | 
<strong>MailChimp Add-On</strong> 1.6.1 | 
<strong>PayPal Add-On</strong> 1.3.1

> This plugin requires the <a href="http://www.gravityforms.com/">Gravity Forms plugin</a>. <strong>Don't use Gravity Forms? <a href="http://www.gravityforms.com/">Buy the plugin</a></strong> and start using this revolutionary plugin!

The [Gravity Forms](http://www.gravityforms.com/) developers don't focus on translating 
their plugin. Instead they concentrate on the core functionalities of the plugin itself. 
Therefore there are regular updates of the Gravity Forms plugin. However, after each 
automatic update, the manually placed Dutch translations are deleted. This plugin fixes 
that issue for all the Dutch WordPress and Gravity Forms users!


== Installation ==

Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your 
WordPress installation and then activate the Plugin from Plugins page.


== Changelog ==

= 2.5.7 =	
*	Updated to Gravity Forms version 1.6.2.1.1, no new translations, but improved a few
*	Added the translations for Gravity Forms v1.6.3 Beta 1
*	Updated to Gravity Forms MailChimp version 1.6.1

= 2.5.6 =
*	Updated to Gravity Forms version 1.6.2, no new translations, but improved a few

= 2.5.5 =
*	Updated to Gravity Forms version 1.6.1, no new translations, but improved a few

= 2.5.4 =
*	Updated to Gravity Forms version 1.6
*	Updated to Gravity Forms User Registration Add-On version 1.2.11
*	Updated to Gravity Forms Campaign Monitor Add-On version 1.9
*	Updated to Gravity Forms PayPal Add-On version 1.3.1

= 2.5.3 =
*	Updated to Gravity Forms User Registration Add-On version 1.2.9

= 2.5.2 =
*	Added support for the WPML Multilingual CMS in request of [Anne Jan Roeleveld](http://www.freshter.com/)

= 2.5.1 =
*	Added translation for Gravity Forms 1.5.3
*	Added translation for Gravity Forms 1.6.rc1
*	Improved the translation of 'please enter', removed a lot 'a.u.b.' texts
*	Improved the translation of 'you' and 'your', remove a lot 'u' and 'uw' texts

= 2.5 =
*	Added the translation of some JavaScript variables wich are not translatable within Gravity Forms itself
*	Added the translation for Gravity Forms 1.6beta3
*	Added the translation for Gravity Forms 1.6beta2

= 2.4.9 =
*	Updated to Gravity Forms User Registration Add-On version 1.2.6.1

= 2.4.8 =
*	Updated to Gravity Forms User Registration Add-On version 1.2.6 (added 3 new translations)

= 2.4.7 = 
*	Updated to Gravity Forms Campaign Monitor Add-On version 1.8
*	Updated to Gravity Forms MailChimp Add-On version 1.5
*	Updated to Gravity Forms User Registration Add-On version 1.2

= 2.4.6 =
*	Updated to Gravity Forms version 1.5.2.8 (added 3 new translations)
*	Updated to Gravity Forms Campaign Monitor Add-On version 1.7
*	Added the translation for Gravity Forms MailChimp Add-On version 1.4
*	Added the translation for Gravity Forms PayPal Add-On version 1.2.3

= 2.4.5 =
*	Improved the translation of "New submission from" from "Nieuw aanmeldingsformulier" to "Nieuwe inzending via" 
*	Replaced the use of the constant WPLANG with "self::$language = get_option('WPLANG', WPLANG);" so the plugin works correct in multisites
*	Enqueue the jQuery datepicker dutch translation only if the language is dutch
*	Removed two unused constants: PLUGIN_NAME and PLUGIN_URL_PAGE

= 2.4.4 =
*	Updated to Gravity Forms version 1.5.2.3
*	Added the translation for "GREENLAND" and "Greenland"
*	Improved the translation of "Label Placement" from "Veldlabel" to "Label positie"
*	Improved the translation of "Right aligned" from "Rechtsuitgelijnd" to "Rechts uitgelijnd"
*	Improved the translation of "Law Enforcement/Security" from "Rechtshandhaving / Veiligheid" to "Rechtshandhaving / veiligheid"
*	Improved the translation of "Form Button Text" from "Tekst voor formulierknop" to "Formulier knop tekst"
*	Improved the translation of "Form Button" from "Formulierknop" to "Formulier knop"
* 	Improved the tranlsations of a lot more texts
 
= 2.4.3 =
*	Added the translation for Gravity Forms version 1.5.2.2
*	Removed the social buttons from the WordPress plugin page
*	Added the translation for Gravity Forms Campaign Monitor Add-On version 1.6

= 2.4.2 = 
*	Added the translation for Gravity Forms version 1.5.2

= 2.4.1 =
*	Fixed the translation of "New Zealand" from "Nieuw formulier" to "Nieuw-Zeeland"
 
= 2.4 =
*	Added the translation for Gravity Forms version 1.5.1.1 (2 new translations)
*	Improved some old translations
*	Added Twitter and Facebook share buttons on plugins page

= 2.3 =
*	Changed the directory structure of the translations, domains and versions
*	Removed all the .PO files from the plugin (are available within the Pronamic GlotPress)
*	Added the translations of Gravity Forms version 1.5
*	Added the translations of Gravity Forms User Registration Add-On version 1.0

= 2.2 = 
*	Replaced PHP 5.3 __DIR__ constant with dirname(__FILE__), plugin should now work on PHP 5.2 (or higher)

= 2.1 =
*	Added the Dutch translation for Gravity Forms version 1.5.RC4.
*	In case of a beta Gravity Forms release load the beta translations, otherwise load the public release translations.

= 2.0 =
*	Added the Dutch translation of the [jQuery UI datepicker](http://jqueryui.com/demos/datepicker/)
	[This Dutch translation of jQuery UI date picker can be found in on Google Code] (http://code.google.com/p/jquery-ui/source/browse/trunk/ui/i18n/jquery.ui.datepicker-nl.js)
	More information about this can be bound on [the weblog of Remco Tolsma](http://remcotolsma.nl/2010/10/gravity-forms-datepicker-in-het-nederlands/)
*	Updated the Dutch translation set to Gravity Forms version 1.5.rc3.4.
*	Added the Dutch translation set of the User Registration Add-On version 1.0.beta3.1.

= 1.4.5 =
*	Added 370 new translations (thanks to [Pim Vellinga](http://twitter.com/brainscrewer)) 

= 1.4.3.1 =
*	Initial release (thanks to [Jelke Boonstra](http://twitter.com/jelkeboonstra), [Karel-Jan Tolsma](http://twitter.com/kjtolsma), 
	[Pim Vellinga](http://twitter.com/brainscrewer), [Remkus de Vries](http://twitter.com/DeFries) 
	and [Jan Egbert Krikken](http://twitter.com/janegbert))


== Links ==

*	[Pronamic](http://pronamic.eu/)
*	[Remco Tolsma](http://remcotolsma.nl/)
*	[Markdown's Syntax Documentation][markdown syntax]

[markdown syntax]: http://daringfireball.net/projects/markdown/syntax
            "Markdown is what the parser uses to process much of the readme file"


== Pronamic plugins ==

*	[Pronamic Google Maps](http://wordpress.org/extend/plugins/pronamic-google-maps/)
*	[Gravity Forms (nl)](http://wordpress.org/extend/plugins/gravityforms-nl/)
*	[Pronamic Page Widget](http://wordpress.org/extend/plugins/pronamic-page-widget/)
*	[Pronamic Page Teasers](http://wordpress.org/extend/plugins/pronamic-page-teasers/)
*	[Maildit](http://wordpress.org/extend/plugins/maildit/)
*	[Pronamic Framework](http://wordpress.org/extend/plugins/pronamic-framework/)
*	[Pronamic iDEAL](http://wordpress.org/extend/plugins/pronamic-ideal/)

