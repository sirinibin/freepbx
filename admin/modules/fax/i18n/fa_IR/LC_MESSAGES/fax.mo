��    |      �  �   �      x
  K   y
  w   �
     =  >   V     �  k  �  7        <     [  $   m  $   �     �      �  (   �                     @     S     `  �   p  �   >     <  n   J  �   �  
   �  !   �     �     �  (   �     '  Y   =     �     �     �     �     �     �     �               &     2  )   ;  1   e     �  +   �     �  9   �  �     &   �  �   �     �     �  �   �     �     �     �  �   �     �     �  7   �  u   %  &   �  I   �       7   "  (   Z  f   �     �     �                 M   2  �   �     4     7     N     c     g  '   �     �     �     �  �   �     �  p   �  *   �     '  $   .     S  �   X  E   G  0   �     �  S   �  %   0   �   V      �   D   �   �   1!     )"  R   A"     �"  �   �"  X   `#  X   �#     $  %   $     ?$     L$     R$  #   W$     {$     �$     �$  
   �$     �$     �$     �$     �$     �$  �  �$  v   �&  �   '  -   �'  r   �'     i(  �  l(  o   �*  '   i+     �+  P   �+  >   �+     5,  1   >,  A   p,     �,  &   �,  /   �,  "   -     =-  -   W-  �   �-  %  ^.     �/  �   �/  �  j0      �1  B   2     Y2  :   b2  M   �2     �2  �   3     �3     �3     �3     4  "   4  /   A4      q4     �4     �4      �4     �4  T   �4  H   I5     �5  R   �5     6  �   6  �   �6  C   g7    �7  -   �8  ,   �8  �   9     �9  I   �9  
   E:  k  P:     �;  (   �;  I   �;  v   8<  L   �<  k   �<  -   h=  G   �=  3   �=  g   >  	   z>     �>  )   �>     �>  =   �>  �   ?  d  �?     "A  %   +A     QA     pA  %   tA  -   �A  %   �A     �A     �A  �   B     �B  q   C  +   ~C  
   �C  8   �C     �C  �   �C  ]   �D  I   AE  5   �E  o   �E  C   1F    uF     �G  o   �G  j  �G  F   jI  t   �I     &J  w  -J  T   �K  W   �K     RL  =   [L     �L     �L     �L  =   �L      M     M  !   +M     MM     _M     sM  "   �M     �M     �M         t   &   	   M   q   S   s   b                      Y               =   d      u   J   p   g   @       
   R      W   l   L   3       a   .   $   A           9   H   5   +   c           ]   X   _       "   <   `      7                   B       8   P          w       6         I   >   *   )           e   [   h       f          {   T   ,         G          \      x             i   m   4   y   1             z   |   ?                         :   V      ^            O              D      K       /   !       E      0   %   2   n   -   C   Q   o       Z      N          k   (   v          F       j   '   U       #           ;   r     fax detection; requires 'faxdetect=' to be set to 'incoming' or 'both' in  "You have selected Fax Detection on this route. Please select a valid destination to route calls detected as faxes to." %s FAX Migrations Failed %s FAX Migrations Failed, check notification panel for details A4 Address to email faxes to on fax detection.<br />PLEASE NOTE: In this version of FreePBX, you can now set the fax destination from a list of destinations. Extensions/Users can be fax enabled in the user/extension screen and set an email address there. This will create a new destination type that can be selected. To upgrade this option to the full destination list, select YES to Detect Faxes and select a destination. After clicking submit, this route will be upgraded. This Legacy option will no longer be available after the change, it is provided to handle legacy migrations from previous versions of FreePBX only. Adds configurations, options and GUI for inbound faxing Always Generate Detection Code Attachment Format Attempt to detect faxes on this DID. Auto generated migrated user for Fax Both Checking for failed migrations.. Checking if legacy fax needs migrating.. Dahdi Default Fax header Default Local Station Identifier Default Paper Size Detect Faxes Dial System FAX ERROR: No FAX modules detected!<br>Fax-related dialplan will <b>NOT</b> be generated.<br>This module requires Fax for Asterisk (res_fax_digium.so) or spandsp based app_fax (res_fax_spandsp.so) to function. ERROR: No Fax license detected.<br>Fax-related dialplan will <b>NOT</b> be generated!<br>This module has detected that Fax for Asterisk is installed without a license.<br>At least one license is required (it is available for free) and must be installed. Email address Email address that faxes appear to come from if 'system default' has been chosen as the default fax extension. Email address that faxes are sent to when using the "Dial System Fax" feature code. This is also the default email for fax detection in legacy mode, if there are routes still running in this mode that do not have email addresses specified. Enable Fax Enable this user to receive faxes Enabled Enclosed, please find a new fax Enclosed, please find a new fax from: %s Error Correction Mode Error Correction Mode (ECM) option is used to specify whether
			 to use ecm mode or not. Fax Fax Configuration Fax Destination Fax Detection Fax Detection Time Fax Detection Wait Fax Detection type Fax Email Destination Fax Enabled Fax Options Fax Ring Fax drivers supported by this module are: Fax for Asterisk (res_fax_digium.so) with licence Fax user %s Finished Migrating fax users to usermanager For Formats to convert incoming fax files to before emailing. Header information that is passed to remote side of the fax transmission and is printed on top of every page. This usually contains the name of the person or entity sending the fax. How long to wait and try to detect fax How long to wait and try to detect fax. Please note that callers to a Dahdi channel will hear ringing for this amount of time (i.e. the system wont "answer" the call, it will just play ringing). Inbound Fax Destination Change Inbound Fax Detection: %s (%s) Inbound faxes now use User Manager users. Therefore you will need to re-assign all of your destinations that used 'Fax Recipients' to point to User Manager users. You may see broken destinations until this is resolved Inherit Invalid Email for Inbound Fax Legacy Legacy: Same as YES, only you can enter an email address as the destination. This option is ONLY for supporting migrated legacy fax routes. You should upgrade this route by choosing YES, and selecting a valid destination! Letter Maximum transfer rate Maximum transfer rate used during fax rate negotiation. Migrated user %s but unable to set email address to %s because an email [%s] was already set for User Manager User %s Migrating all fax users to usermanager Migrating faxemail field in the fax_users table to allow longer emails... Minimum transfer rate Minimum transfer rate used during fax rate negotiation. Moving simu_fax feature code from core.. NV Fax Detect: Use NV Fax Detection; Requires NV Fax Detect to be installed and recognized by asterisk NVFax New fax from: %s New fax received No No Inbound Routes to migrate No fax detection methods found or no valid license. Faxing cannot be enabled. No: No attempts are made to auto-determine the call type; all calls sent to destination set in the 'General' tab. Use this option if this DID is used exclusively for voice OR fax. On Outgoing Email address Outgoing fax results PDF Received & processed: %s Removing field %s from incoming table.. Removing old globals.. Reset SIP Select the default paper size.<br/>This specifies the size that should be used if the document does not specify a size.<br/> If the document does specify a size that size will be used. Settings Sip: use sip fax detection (t38). Requires asterisk 1.6.2 or greater and 'faxdetect=yes' in the sip config files Spandsp based app_fax (res_fax_spandsp.so) Submit Successfully migrated faxemail field TIFF The following Inbound Routes had FAX processing that failed migration because they were accessing a device with no associated user. They have been disabled and will need to be updated. Click delete icon on the right to remove this notice. The outgoing Fax Machine Identifier. This is usually your fax number. Type of fax detection to use (e.g. SIP or DAHDI) Type of fax detection to use. Unable to migrate %s, because [%s]. Please check your 'Fax Recipients' destinations Updating simu_fax in miscdest table.. User Manager users '%s' have the ability to receive faxes but have no email address defined so they will not be able to receive faxes over email, Via WARNING: Failed migration. Email length is limited to 50 characters. When no fax modules are detected the module will not generate any detection dialplan by default. If the system is being used with phyical FAX devices, hylafax + iaxmodem, or other outside fax setups you can force the dialplan to be generated here. Where to send the faxes Whether to ring while attempting to detect fax. If set to no silence will be heard Yes Yes: try to auto determine the type of call; route to the fax destination if call is a fax, otherwise send to regular destination. Use this option if you receive both voice and fax calls on this line Your maximum transfer rate is set to 2400 in certain circumstances this can break faxing Your minimum transfer rate is set to 2400 in certain circumstances this can break faxing Zaptel all migrations succeeded successfully already done blank done duplicate, removing old from core.. failed migrated migrating defaults.. not needed not present removed starting migration unknown error use  Project-Id-Version: PACKAGE VERSION
Report-Msgid-Bugs-To: 
POT-Creation-Date: 2017-05-23 17:31-0700
PO-Revision-Date: 2016-08-26 03:04+0200
Last-Translator: Media <mousavi.media@gmail.com>
Language-Team: Persian (Iran) <http://weblate.freepbx.org/projects/freepbx/fax/fa_IR/>
Language: fa_IR
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
Plural-Forms: nplurals=2; plural=n != 1;
X-Generator: Weblate 2.4
  تشخیص دورنگار؛ ملزومات 'faxdetect='باید تنظیم شود 'ورودی' یا 'هر دو' در  "شما تشخیص دورنگار را برای این مسیر تنطیم کرده اید.لطفا یک مقصد برای تشخیص دورنگار تعیین کنید." %s جابجایی دورنگار ناموفق %s جابجایی دورنگار ناموفق.برای توضیح بیشتر به پنل هشدارها بروید A4 آدرسی که فکسهای دریافتی به آن ایمیل میشود.<br />PLEASE NOTE: In this version of FreePBX, you can now set the fax destination from a list of destinations. Extensions/Users can be fax enabled in the user/extension screen and set an email address there. This will create a new destination type that can be selected. To upgrade this option to the full destination list, select YES to Detect Faxes and select a destination. After clicking submit, this route will be upgraded. This Legacy option will no longer be available after the change, it is provided to handle legacy migrations from previous versions of FreePBX only. افزودن تنظیمات، گزینه ها و رابط گرافیکی برای دورنگار دریافتی تولید همیشگی کد تشخیص فرمت پیوست تلاش برای تشخیص دورنگار در این داخلی مستقیم. جابجایی خودکار کاربر برای دورنگار هردو بررسی برای جابجایی ناموفق.. بررسی جابجایی دورنگار در صورت نیاز.. دهدی (Dahdi) سربرگ پیشفرض دورنگار شناسه پیشفرض ایستگاه محلی اندازه پیشفرض کاغذ تشخیص دورنگار سیستم شماره گیری دورنگار خطا: ماژول فکس پیدا نشد!<br>Fax-related dialplan will <b>NOT</b> be generated.<br>This module requires Fax for Asterisk (res_fax_digium.so) or spandsp based app_fax (res_fax_spandsp.so) to function. خطا: مجوز استفاده از امکان فکس پیدا نشد.<br>Fax-related dialplan will <b>NOT</b> be generated!<br>This module has detected that Fax for Asterisk is installed without a license.<br>At least one license is required (it is available for free) and must be installed. آدرس ایمیل آدرس ایمیلی که  دورنگارها به آن ارسال میشوند اگر 'پیشفرض سیستم' به عنوان شماره داخلی پیشفرض دورنگار انتخاب شده باشد. آدرس ایمیلی که فکس ها در صورت استفاده از کد ویژه "Dial System Fax" به آن ارسال میشوند.همچنین از این آدرس برای حالت موروثی نیز استفاده خواهد شد، درصورتی که مسیرهایی در این حالت وجود داشته و آدرس ایمیلی برای ایشان لحاظ نشده باشد. فعال سازی دورنگار دریافت دورنگار را برای کاربر فعال کن فعال محصور, یک دورنگار جدید پیدا کنید محصور, لطفا یک دورنگار جدید پیدا کنید از：%s حالت تصحیح خطا Error Correction Mode (ECM) option is used to specify whether
\t\t\t to use ecm mode or not.Error Correction Mode (ECM) option is used to specify whether
\t\t\t to use ecm mode or not. دورنگار تنظیمات دورنگار مقصد دورنگار تشخیص دورنگار زمان تشخیص دورنگار انتظار برای تشخیص دورنگار تشخیص نوع دورنگار ایمیل مقصد فکس دورنگار فعال گزینه های دورنگار زنگ فکس درایورهای دورنگار پشتیبانی شده با این ماژول ： دورنگار برای استریسک (res_fax_digium.so) با مجوز دورنگار کاربر %s اتمام انتقال دورنگار کاربران به مدیریت کاربر برای فرمت هایی که دورنگارهای دریافتی باید ب آنها تبدیل شده سپس به ایمیل ارسال شوند. اطلاعات سربرگ که در بالای تمامی فکسهای ارسالی چاپ میشود.معمولا شامل اطلاعات شخص و یا شرکت ارسال کننده فکس میباشد. مدت زمان انتظار برای شناسایی دورنگار مدت زمان انتظار برای تشخیص فکس. لطفا توجه کنید تماس گیرنده در کانال دهدی صدای زنگ خوردن را در این زمان خواهد شنید (i.e. the system wont "answer" the call, it will just play ringing). تغییر مقصد دورنگار ورودی تشخیص فکس های ورودی: %s (%s) Inbound faxes now  use User Manager users. Therefore you will need to re-assign all of your destinations that used 'Fax Recipients' to point to User Manager users. You may see broken destinations until this is resolved ارثی ایمیل نادرست برای ارسال دورنگار دریافتی میراث ارثی: انند بله، فقط میتواند یک آدرس ایمیل به عنوان مقصد وارد شود. این گزینه فقط برای انتقال مسیر فکس های قدیمی استفاده میشود. شما با انتخاب گزینه بله باید مسیر را به روزکنید، و یک مسیر معتبر انتخاب کنید! نامه بیشترین امتیاز انتقال بیشترین سرعت استفاده شده برای تبادل فکس. Migrated user %s but unable to set email address to %s because an  email [%s] was already set for User Manager User %s انتقال تمام کاربران فکس به مدیریت کاربران انتقال فیلد فکس میل در جدول fax_users برای ایمیل های طولانی تر... حداقل سرعت تبادل اطلاعات کمترین سرعت استفاده شده برای تبادل فکس. انتقال کد ویژه simu_fax از هسته.. NV Fax Detect: Use NV Fax Detection; Requires NV Fax Detect  to be installed and recognized by asterisk فکس NV دورنگار جدید از:%s دورنگار جدید دریافت شد خیر مسیر ورودی برای انتقال وجود ندارد روش درستی برای تشخیص فکس انتخاب نشد و یا مجوز قانونی وجود نداشت. عملیات فکس نمیتواند فعال شود. خیر: تلاشی برای تشخیص خودکار نوع تماس انجام نشد; تمامی تماس ها به مقصد تعیین شده در تب 'عمومی' فرستاده میشود. این گزینه برای DIDهایی استفاده میشود که انحصارا به عنوان فکس و یا تماس ساده استفاده میشوند. روشن آدرس ایمیل ارسال فکس نتایج فکس ارسالی PDF رسیده و پردازش شده: %s حذف فیلد %s از جدول ورودی.. حذف سراسری های قبلی.. بازنشانی SIP انتخاب اندازه برگه پیشفرض.<br/>این اندازه برای مدارکی که سایز مشخصی ندارند لحاظ میشود.<br/>اگر مدرکی سایز مشخصی داشت همان سایز استفاده میشود. تنظیمات Sip: use sip fax  detection (t38). Requires asterisk 1.6.2 or greater and 'faxdetect=yes' in the sip config files Spandsp  based app_fax (res_fax_spandsp.so) ارسال فیلد فکس میل با موفقیت منتقل شد TIFF The following  Inbound Routes had FAX processing that failed migration because they were accessing a device with no associated user. They have been disabled and will need to be updated. Click delete icon on the right to remove this notice. شناسه ماشین فکس خارجی. به طور معمول شماره فکس شماست. نوع شناسایی فکس مورد استفاده  (e.g. SIP or DAHDI) نوع شناسایی فکس مورد استفاده. عدم امکان انتقال %s، به دلیل [%s]. لطفا 'گیرنده فکس' را بررسی کنید به روزرسانی جدول simu_fax در مقاصدمختلف.. در مدیریت کاربران کاربران '%s' میتوانند فکسها را دریافت کنند اما آدرس ایمیلی برایشان تعریف نشده بنا بر این آنها نمیتوانند فکس را در ایمیلشان داشته باشند، با هشدار: انتقال ناموفق. طول ایمیل نباید بیشتر از 50 کاراکتر باشد. وفتی ماژول فکسی وجود ندارد هیچ نقشه تماسی به صورت خودکار تولید نمیشود.اگر از دستگاه فکس، hylafax + iaxmodem ،یا دیگر پلتفرم ها استفاده میکنید میتوانید نقشه تماس را به صورت دستی تولید کرده و در اینجا قرار دهید. محلی که دورنگارها به آنجا ارسال میشوند چگونگی زنگ خوردن در حال شناسایی فکس.اگر بدون صدا تنظیم نشده باشد بله بله:تلاش برای تشخیص خودکار نوع تماس; مسیریابی به مقصد فکس برای این دست تماس ها، درغیراینصورت تماس به مقصد معمول فرستاده میشود. از این گزینه وقتی استفاده میکنیم که از یک خط برای دریافت تماس و فکس استفاده میشود بالاترین سرعت جابجایی شما روی 2400 تنظیم شده است پایین ترین سرعت جابجایی شما روی 2400 تنظیم شده است زپتل تمامی انتقالات با موفقیت انجام شد انجام شد خالی انجام شد چند گانه، نتایج قدیمی حذف میشوند.. نا موفق انتقال داده شده پیشفرضهای انتقال.. لازم نیست موجود نیست حذف شده شروع عملیات انتقال خطای تعریف نشده استفاده  