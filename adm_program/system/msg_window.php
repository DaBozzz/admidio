<?php
/******************************************************************************
 * Popup-Window mit Informationen
 *
 * Copyright    : (c) 2004 - 2007 The Admidio Team
 * Homepage     : http://www.admidio.org
 * Module-Owner : Markus Fassbender
 * License      : GNU Public License 2 http://www.gnu.org/licenses/gpl-2.0.html
 *
 * err_code - Code fuer die Information, die angezeigt werden soll
 * err_text - Text, der innerhalb einer Meldung angezeigt werden kann
 * window    - true wenn das script über window.open anstatt über das tooltip aufgerufen wird
 *
 *****************************************************************************/

require("common.php");

// lokale Variablen der Uebergabevariablen initialisieren
$req_err_code = null;
$req_err_text = null;

// Uebergabevariablen pruefen

if(isset($_GET['err_code']) && strlen($_GET['err_code']) > 0)
{
    $req_err_code = strStripTags($_GET['err_code']);
}
else
{
    $g_message->show("invalid");
}

if(isset($_GET['err_text']))
{
    $req_err_text = strStripTags($_GET['err_text']);
}

// Html-Kopf ausgeben
if(isset($_GET['window']))
{
$g_layout['title']    = "Hinweis";
$g_layout['onload']   = "windowresize()";
$g_layout['includes'] = false;
require(THEME_SERVER_PATH. "/overall_header.php");


// Html des Modules ausgeben
echo "
<div class=\"groupBox\" id=\"message_window\">
    <div class=\"groupBoxHeadline\">Hinweis</div>
    <div class=\"groupBoxBody\">";
}
        switch ($req_err_code)
        {
            case "bbcode":
                echo "Die Beschreibung bei einigen Modulen (Ankündigungen, Terminen, Gästebuch und Weblinks)
                      können mit verschiedenen Tags (BBCode) formatiert werden. Dafür müssen die
                      hier aufgelisteten Tags um den entsprechenden Textabschnitt gesetzt werden.<br /><br />
                      Beispiele:<br /><br />
                      <table class=\"tableList\" style=\"width: auto;\" cellspacing=\"0\">
                         <tr>
                            <th style=\"width: 155px;\">Beispiel</th>
                            <th>BBCode</th>
                         </tr>
                         <tr>
                            <td>Text <b>fett</b> darstellen</td>
                            <td>Text <b>[b]</b>fett<b>[/b]</b> darstellen</td>
                         </tr>
                         <tr>
                            <td>Text <u>unterstreichen</u></td>
                            <td>Text <b>[u]</b>unterstreichen<b>[/u]</b></td>
                         </tr>
                         <tr>
                            <td>Text <i>kursiv</i> darstellen</td>
                            <td>Text <b>[i]</b>kursiv<b>[/i]</b> darstellen</td>
                         </tr>
                         <tr>
                            <td>Text <span style=\"font-size: 14pt;\">groß</span> darstellen</td>
                            <td>Text <b>[big]</b>groß<b>[/big]</b> darstellen</td>
                         </tr>
                         <tr>
                            <td>Text <span style=\"font-size: 8pt;\">klein</span> darstellen</td>
                            <td>Text <b>[small]</b>klein<b>[/small]</b> darstellen</td>
                         </tr>
                         <tr>
                            <td style=\"text-align: center;\">Text zentriert darstellen</td>
                            <td><b>[center]</b>Text zentriert darstellen<b>[/center]</b></td>
                         </tr>
                         <tr>
                            <td>Einen <a href=\"http://". $g_current_organization->getValue("org_homepage"). "\">Link</a> setzen</td>
                            <td>Einen <b>[url=</b>http://www.beispiel.de<b>]</b>Link<b>[/url]</b> setzen</td>
                         </tr>
                         <tr>
                            <td>Eine <a href=\"mailto:". $g_preferences['email_administrator']. "\">Mailadresse</a> angeben</td>
                            <td>Eine <b>[email=</b>webmaster@demo.de<b>]</b> Mailadresse<b>[/email]</b> angeben</td>
                         </tr>
                         <tr>
                            <td>Ein Bild <img src=\"". THEME_PATH. "/images/admidio_logo_20.png\" /> anzeigen</td>
                            <td>Ein Bild <b>[img]</b>http://www.beispiel.de/bild.jpg<b>[/img]</b> anzeigen</td>
                         </tr>
                      </table>";
                break;

            case "category_global":
                // alle Organisationen finden, in denen die Orga entweder Mutter oder Tochter ist
                $organizations = $g_current_organization->getValue("org_longname");
                $organizations .= implode(",<br />- ", $g_current_organization->getReferenceOrganizations(true, true, true));

                echo "Profilfelder von Kategorien bei denen diese Option aktiviert ist, erscheinen im Profil
                      folgender Organisationen:
                      <p><strong>- $organizations</strong></p>
                      Möchtest du die Daten nur in deiner Organisation sehen, dann sollte diese Option deaktiviert werden.";
                break;

            case "condition":
                echo "Hier kannst du Bedingungen zu jedem Feld in deiner neuen Liste eingeben.
                      Damit wird die ausgewählte Rolle noch einmal nach deinen Bedingungen
                      eingeschränkt.<br /><br />
                      Beispiele:<br /><br />
                      <table class=\"tableList\" style=\"width: 100%;\" cellspacing=\"0\">
                         <tr>
                            <th style=\"width: 75px;\">Feld</th>
                            <th style=\"width: 110px;\">Bedingung</th>
                            <th>Erklärung</th>
                         </tr>
                         <tr>
                            <td>Nachname</td>
                            <td><b>Schmitz</b></td>
                            <td>Sucht alle Benutzer mit dem Nachnamen Schmitz</td>
                         </tr>
                         <tr>
                            <td>Nachname</td>
                            <td><b>Mei*</b></td>
                            <td>Sucht alle Benutzer deren Namen mit Mei anfängt</td>
                         </tr>
                         <tr>
                            <td>Geburtstag</td>
                            <td><b>&gt; 01.03.1986</b></td>
                            <td>Sucht alle Benutzer, die nach dem 01.03.1986 geboren wurden</td>
                         </tr>
                         <tr>
                            <td>Ort</td>
                            <td><b>Köln oder Bonn</b></td>
                            <td>Sucht alle Benutzer, die aus Köln oder Bonn kommen</td>
                         </tr>
                         <tr>
                            <td>Telefon</td>
                            <td><b>*241*&nbsp;&nbsp;*54</b></td>
                            <td>Sucht alle Benutzer, deren Telefonnummer 241 enthält und
                               mit 54 endet</td>
                         </tr>
                         <tr>
                            <td>Ja/Nein Feld</td>
                            <td><b>Ja</b></td>
                            <td>Sucht alle Benutzer bei denen ein Häckchen gesetzt wurde</td>
                         </tr>
                      </table>";
                break;

            case "date_global":
                // alle Organisationen finden, in denen die Orga entweder Mutter oder Tochter ist
                $organizations = $g_current_organization->getValue("org_longname");
                $organizations .= implode(",<br />- ", $g_current_organization->getReferenceOrganizations(true, true, true));

                echo "Termine / Ankündigungen, die diese Option aktiviert haben, erscheinen auf den Webseiten
                      folgender Organisationen:
                      <p><strong>- $organizations</strong></p>
                      Moderatoren dieser Organisationen können den Termin / Ankündigung dann bearbeiten
                      bzw. die Option zurücksetzen.";
                break;

            case "date_location_link":
                echo "Geben Sie genügend Informationen zum Treffpunkt ein, so kann ein Link bzw. eine Route zu
                diesem Treffpunkt über Google-Maps erstellt werden.";
                break;

            case "enable_rss":
                echo "Admidio kann RSS-Feeds für verschiedene Module (Ankündigungen,
                      Termine, Gästebuch und Weblinks) auf den jeweiligen Übersichtsseiten
                      bereitstellen, die dann über den Browser einem Feedreader zugeordnet
                      werden können.";
                break;

            case "field":
                echo "Es können beliebig viele zusätzliche Felder definiert werden.
                      Diese werden im Profil der einzelnen Benutzer angezeigt und können dort auch
                      bearbeitet werden. Außerdem stehen diese Felder bei den Eigenen Listen zur
                      Verfügung.";
                break;

            case "field_hidden":
                echo "Ein Feld ist normalerweise für alle Benutzer sichtbar. Wird diese Funktion
                      nicht ausgewählt, so können die Daten nur von Benutzern gesehen werden,
                      die das Recht haben alle Benutzer zu editieren. Im eigenen Profil kann der Benutzer
                      diese Daten auch sehen.";
                break;

            case "field_disabled":
                echo "Wird ein Feld gesperrt, so können Benutzer im eigenen Profil dieses Feld nicht
                      bearbeiten. Es kann nur noch von Benutzern bearbeitet werden, die das Rollenrecht
                      besitzen alle Benutzer zu editieren.";
                break;

            case "field_mandatory":
                echo "Felder, die als Pflichtfelder markiert sind, müssen immer gefüllt werden.
                      Dies gilt für die Registrierung, aber auch bei der gewöhnlichen
                      Profildatenbearbeitung.";
                break;

            case "file_size":
                echo "Hier kannst Du die maximal zulässige Größe einer Datei für das
                      jeweilige Modul in Kilobyte definieren.<br /><br />
                      Wenn du 0 als Dateigröße einträgst, deaktivierst du die entsprechende
                      Funktion für alle Benutzer.";
                break;

            case "leader":
                echo "Leiter werden in den Mitgliederlisten dieser Rolle gesondert aufgeführt.<br /><br />
                      Leiter haben außerdem die Möglichkeit neue Mitglieder aus der Organisation
                      der Rolle zu zuordnen oder vorhandene Mitglieder zu entfernen.";
                break;

            case "nickname":
                echo "Mit diesem Namen kannst du dich später auf der Homepage anmelden.<br /><br />
                      Damit du ihn dir leicht merken kannst, solltest du deinen Spitznamen oder Vornamen nehmen.
                      Auch Kombinationen, wie zum Beispiel <i>Andi78</i> oder <i>StefanT</i>, sind möglich.";
                break;

            case "password":
                echo "Das Passwort wird verschlüsselt gespeichert.
                      Es ist später nicht mehr möglich dieses nachzuschauen.
                      Aus diesem Grund solltest du es dir gut merken.";
                break;

            case "rolle_benutzer":
                echo "Rollen, die diese Option aktiviert haben, haben die Berechtigung
                      Benutzerdaten (außer Passwörter) und Rollenzugehörigkeiten
                      anderer Mitglieder zu bearbeiten.<br />
                      Außerdem haben sie Zugriff auf die Benutzerverwaltung und können
                      dort neue Benutzer anlegen oder alte Benutzer löschen.";
                break;

            case "role_show_list":
                echo "Alle angemeldeten Benutzer können die Mitgliederlisten der entsprechenden Rolle
                      aufrufen und die Profile der Mitglieder einsehen.
                      Wird dieses Flag nicht gesetzt, so können normale Benutzer die Mitgliedschaft
                      zu dieser Rolle nicht sehen. Sie wird auch nicht im Profil angezeigt.";
                break;

            case "role_mail_logout":
                echo "Besucher der Homepage, die nicht eingeloggt sind, können E-Mails an diese Rolle
                      schreiben, die dann automatisch an alle Mitglieder weitergeleitet wird.";
                break;

            case "rolle_zuordnen":
                echo "Benutzer dieser Rolle haben Zugriff auf die Rollenverwaltung und können neue
                      Rollen erstellen, verwalten und anderen Benutzern Rollen zuordnen.";
                break;

            case "rolle_mail":
                echo "Deine E-Mail wird an alle Mitglieder der ausgewählten Rolle geschickt, sofern
                      diese ihre E-Mail-Adresse im System hinterlegt haben.<br /><br />
                      Wenn du eingeloggt bist stehen dir weitere Rollen zur Verfügung, an die du E-Mails
                      schreiben kannst.";
                break;

            case "rolle_ecard":
                echo "Deine Grußkarte wird an ein Mitglied der ausgewählten Rolle geschickt, sofern
                      diese ihre E-Mail-Adresse im System hinterlegt hat.<br /><br />
                      Unter der Rollenauswahl besteht die Möglichkeit ein Mitglied dieser Rolle oder die gesamte Rolle auszuwählen.";
                break;

            case "role_assign":
                echo "Wähle bitte eine Rolle aus, der alle importierten Benutzer automatisch zugeordnet werden.";
                break;

            case "user_field_description":
                echo $g_current_user->getProperty($req_err_text, "usf_description");
                break;

            //Downloadmodulhilfen
            case "dateiname":
                echo "Die Datei sollte so benannt sein, dass man vom Namen auf den Inhalt schließen kann.
                   Der Dateiname hat Einfluss auf die Anzeigereihenfolge. In einem Ordner in dem z.B. Sitzungsprotokolle
                   gespeichert werden, sollten die Dateinamen immer mit dem Datum beginnen (jjjj-mm-tt).";
                break;

            case "folderNotExists":
                echo "Der Ordner existiert physikalisch nicht auf dem Server. Der Ordner sollte aus der Datenbank gelöscht werden";
                break;

            case "fileNotExists":
                echo "Die Datei existiert physikalisch nicht auf dem Server. Die Datei sollte aus der Datenbank gelöscht werden";
                break;

            //Fotomodulhifen

           case "photo_up_help":
                echo " <h3>Was ist zu tun?</h3>
                    Auf den &bdquo;Durchsuchen&ldquo; Button klicken und die gewünschte Bilddatei auf der
                    Festplatte auswählen. Den Vorgang ggf. bis zu fünfmal wiederholen,
                    bis alle Felder gefüllt sind. Dann auf &bdquo;Bilder hochladen&ldquo; klicken und ein wenig Geduld haben.
                    <br />
                    <h3>Hinweise:</h3>
                    Die Bilder müssen im JPG Format gespeichert sein.
                    Die Bilder werden automatisch auf eine Auflösung von ".$g_preferences['photo_save_scale']." Pixel der
                    längeren Seite skaliert (andere Seite im Verhältnis) bevor sie gespeichert werden.
                    Der Name der Dateien spielt keine Rolle, da sie automatisch mit fortlaufender
                    Nummer benannt werden.<br />
                    Da auch bei schnellen Internetanbindungen das Hochladen von größeren Dateien einige
                    Zeit in Anspruch nehmen kann, empfehlen wir zunächst alle hoch zu ladenden Bilder in einen
                    Sammelordner zu kopieren und diese dann mit einer Bildbearbeitungssoftware auf ".$g_preferences['photo_save_scale']." Pixel
                    (längere Bildseite) zu skalieren. Die JPG-Qualität sollte beim Abspeichern auf mindestens 90%
                    (also geringe Komprimierung) gestellt werden.
                    Die maximale Dateigröße eines hochgeladenen Bildes wird nur durch die Servereinstellungen beschränkt.
                    ";
                break;

            case "veranst_help":
                echo "<h3>Was ist zu tun?</h3>
                    Alle offenen Felder ausfüllen. Die Felder Veranstaltung und Beginn sind Pflichtfelder. Ggf. auswählen
                    welcher Veranstaltung die Neue untergeordnet werden soll, z.B. &bdquo;Tag 3&ldquo; in &bdquo;Turnier 2010&ldquo; (solche Unterteilungen sind empfehlenswert bei vielen Bildern).
                    Die Felder Ende und Fotografen sind optional. Nur Freigegebene Veranstaltungen sind für Homepagebesucher sichtbar. Möchte man z.B. erst alle Bilder hochladen
                    oder auch nur schon mal alle Daten eintragen, kann man die Freigabe einfach später setzen.
                    Danach auf Speichern klicken.
                    ";
                break;

            case "folder_not_found":
                echo " <h3>Warnung!!!</h3>
                    Der zugehörige Ordner wurde nicht gefunden. Sollte er bewusst über FTP gelöscht worden sein
                    oder nicht mehr die Möglichkeit bestehen ihn wieder herzustellen, bitte
                    den Datensatz mit klick auf das (<img src=\"". THEME_PATH. "/icons/cross.png\" style=\"vertical-align: top;\" />)Icon löschen.
                    Besuchern der Website ohne Fotoverwaltungsrecht, wird diese Veranstaltung nicht mehr angezeigt.";
                break;

            case "not_approved":
                echo " <h3>Warnung!!!</h3>
                    Die Veranstaltung ist z.Zt. gesperrt und wird Homepagebesuchern deswegen nicht angezeigt. Zum Freigeben bitte
                    den entsprechende Icon (<img src=\"". THEME_PATH. "/icons/key.png\" />)
                    in der Bearbeitungszeile nutzen.";
                break;

            //Captcha-Hilfen
            case "captcha_help":
                echo " <h3>Was ist das für ein Bestätigungscode?</h3>
                    Hierbei handelt es sich um ein Captcha. Ein Captcha dient zur Spamerkennung. Mit Hilfe des Bildes wird versucht festzustellen, ob das
                    Formular von einem User oder einem Script/Spambot ausgefüllt wurde. <br /> Bitte trage den im Bild angezeigten
                    4- bis 6-stelligen Code in das Formularfeld ein.";
                break;

            default:
                echo "Es ist ein Fehler aufgetreten.";
                break;
        }
if(isset($_GET['window']))
{
echo "</div>
</div>

<ul class=\"iconTextLinkList\">
    <li>
        <span class=\"iconTextLink\">
            <a href=\"javascript:window.close();\"><img
            src=\"". THEME_PATH. "/icons/door_in.png\" alt=\"Schließen\" /></a>
            <a href=\"javascript:window.close();\">Schließen</a>
        </span>
    </li>
</ul>";

require(THEME_SERVER_PATH. "/overall_footer.php");
}
?>