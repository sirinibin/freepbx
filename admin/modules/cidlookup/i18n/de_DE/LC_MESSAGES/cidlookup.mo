��    <      �  S   �      (  )   )  �   S  �       �     �     �     �  r   �  
   )     4  	   F     P     ^     n     �     �     �     �     +	     2	     >	  $   D	     i	     o	     v	     {	     �	  	   �	  3   �	     �	  
   �	     �	     
     
     
     
     
     3
      <
  	   ]
     g
  &   p
     �
     �
  @   �
     �
     �
  /   �
          %     8  :   D          �     �  &   �     �  p   �  o   0  �  �  3   W  �   �  �  J  
   "     -     6     T  �   b  
   �     �  	         
          +     B  	   N     X  �   f                -  2   3     f     l     s     x     �     �  @   �     �  
   �     �                '     ,     2     K  )   T  	   ~     �  (   �     �     �  @   �            7        S     Z  
   n  J   y     �     �     �  ,   �       p     �   �     :       %                       "   5   $   1                  2   *           )   3      /                '            +              8   9         <             0   	           (             .                !           ,   
      ;           4      7   &          -              #       6           Use OpenCNAM [https://www.opencnam.com/] <p>If you need to create an OpenCNAM account, you can visit their website: <a href="https://www.opencnam.com/register" target="_blank">https://www.opencnam.com/register</a></p> A Lookup Source let you specify a source for resolving numeric CallerIDs of incoming calls, you can then link an Inbound route to a specific CID source. This way you will have more detailed CDR reports with information taken directly from your CRM. You can also install the phonebook module to have a small number <-> name association. Pay attention, name lookup may slow down your PBX Account SID: Actions Add CIDLookup Source Admin Allows CallerID Lookup of incoming calls against different sources (OpenCNAM, MySQL, HTTP, ENUM, Phonebook Module) Auth Token CID Lookup Source CIDLookup Cache Results CallerID Lookup CallerID Lookup Sources Character Set Database Database Name Decide whether or not cache the results to astDB; it will overwrite present values. It does not affect Internal source behavior Delete Description ENUM: Enter a description for this source. HTTP: HTTPS: Host Host name or IP address Internal Internal: It queries a MySQL database to retrieve caller name List Sources MySQL Host MySQL Password MySQL Username MySQL: No None Not yet implemented OpenCNAM OpenCNAM Requires Authentication OpenCNAM: Password Password to use in HTTP authentication Path Port Port HTTP(s) server is listening at (default http 80, https 443) Query Reset Select the source type, you can choose between: Source Source Description Source type Sources can be added in Caller Name Lookup Sources section Submit Type Username Username to use in HTTP authentication Yes Your OpenCNAM Account SID. This can be found on your OpenCNAM dashboard page: https://www.opencnam.com/dashboard Your OpenCNAM Auth Token. This can be found on your OpenCNAM dashboard page: https://www.opencnam.com/dashboard Project-Id-Version: PACKAGE VERSION
Report-Msgid-Bugs-To: 
POT-Creation-Date: 2017-01-20 12:54-0800
PO-Revision-Date: 2017-01-11 13:44+0200
Last-Translator: Sven <spiderrs4@web.de>
Language-Team: German <http://weblate.freepbx.org/projects/freepbx/cidlookup/de_DE/>
Language: de_DE
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
Plural-Forms: nplurals=2; plural=n != 1;
X-Generator: Weblate 2.4
  Verwenden Sie OpenCNAM [https://www.opencnam.com/] <p>Wenn Sie ein OpenCNAM-Konto erstellen müssen, können Sie folgende Website besuchen: <a href="https://www.opencnam.com/register" target="_blank">https://www.opencnam.com/register</a></p> Mit einer Lookup Quelle können Sie eine Quelle für das Auflösen numerischer AnruferID's eingehender Anrufe angeben, anschließend können Sie eine Inbound Route mit einer bestimmten CID-Quelle verknüpfen. Auf diese Weise erhalten detailliertere CDR-Berichte mit Informationen direkt aus Ihren CRM. Sie können auch das Telefonbuch-Modul installieren, um kleine Nummern <-> Nameszuordnung zu haben. Achtung: Eine Namenssuche verlangsamt möglicherweise Ihre TK-Anlage. Konto SID: Aktionen CID Lookup Quelle hinzufügen Administrator Ermöglicht bei eingehenden Anrufen eine AnruferID Suche mit verschiedenen Quellen (OpenCNAM, MySQL, HTTP, ENUM, Phonebook Module). Auth-Token CID-Suchquelle CID-Suche Cache Ergebnisse AnruferID-Suche Anrufer-ID Suchquellen Zeichensatz Datenbank Datenbankname Entscheiden Sie, ob die Ergebnisse in astDB zwischengespeichert werden sollen; Es überschreibt die aktuellen Werte. Dies hat keine Auswirkungen auf das interne Quellverhalten. Löschen Beschreibung ENUM: Geben Sie eine Beschreibung für diese Quelle ein. HTTP: HTTPS: Host Hostname oder IP Adresse Intern Intern: Die Abfrage des Anrufernamens erfolgt aus einer MySQL-Datenbank. Quellen auflisten MySQL Host MySQL Passwort MySQL Benutzername MySQL: Nein keine Noch nicht implementiert OpenCNAM OpenCNAM erfordert eine Authentifizierung OpenCNAM: Passwort Passwort für die HTTP-Authentifizierung Pfad Port Der verwendete HTTP(s) Server Port (Standard http 80, https 443) Abfrage Zurücksetzen Wählen Sie den Quelltyp. Sie können wählen zwischen: Quelle Quellenbeschreibung Quellentyp Quellen können im Abschnitt "Anrufer-ID Suchquellen" hinzugefügt werden. Bestätigen Typ Benutzername Benutzername für die HTTP-Authentifizierung Ja Ihre OpenCNAM-Konto-SID. Diese finden Sie auf Ihrer OpenCNAM Dashboard-Seite: https://www.opencnam.com/dashboard Ihren OpenCNAM Authentifizierungs-Token. Diesen finden Sie auf Ihrer OpenCNAM Dashboard-Seite: https://www.opencnam.com/dashboard 