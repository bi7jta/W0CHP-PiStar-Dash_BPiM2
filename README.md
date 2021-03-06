## About `W0CHP-PiStar-Dash`, and Some Warnings

**DO NOT contact me for support, bugs, etc...**

This is my *personal* and highly customized Pi-Star dashboard, and related
binaries.  I offer ZERO support. This is here for your hacking and enjoyment,
and you're fully on your own. *Use at your own risk*, and DO NOT ask me for
support.  Nor should you file/report any bugs etc. on any official Pi-Star
medium...this is not an oficial Pi-Star release.

If you ask me to support, **I will ignore you.** It's strongly recommended that
you read and heed the [rules and
caveats](https://w0chp.net/w0chp-pistar-dash/#the-rules-and-caveats----important).

## Features and enhancements (not an exhaustive list)

* Updated user interface elements galore, styling, wider, bigger, updated fonts, etc.

* Improved and graphical CSS/color styling configuration page; easily change the look and feel of the dashboard.

* More Last Heard rows displayed (40 vs. 20).

* Searchable drop-downs for massive host lists in configuration/admin pages. E.g. YSF Hosts, XLX Hosts, DMR Hosts, etc.

* BrandMeister Manager revamps galore:

  * Now displays connected actual talk group names.

  * Reflector functionality removed per [BrandMeister's announcement](https://news.brandmeister.network/brandmeister-dmr-reflectors-support-ending-by-end-of-2020/).

  * Connected dynamic talk groups now display idle-timeout time (due to no TX).

  * Added ability to mass-drop your static talk groups; and mass re-add the previously
    linked static talk groups.

   * Added ability to batch add/delete up to 5 static talk groups at a time (for now)

* TGIF Manager; now displays connected actual talk group names.

* "Instant Mode Manager" added to admin page; allows you to instantly pause or resume selected radio modes. Handy for attending
  nets, quieting a busy mode, to temporarily eliminate "mode monopolization", etc.

* DMR JitterTest and related form added.

* RF activity moved to top on dashboard.

* YSF link manager gives the ability to change links/rooms on-the-fly, rather than going through the large (and slow) configuration page.

* Connected FCS and YSF reflector names and numerical ID both displayed in dashboard left panel.

* Ability to configure POCSAG hang-time from the config page.

* Additional hardware and system information displayed in top header.

* Admin page split up into logical sub-sections/sub-pages, in order to present
  better feedback messages when making changes.
  * Note: Last-Heard and other dynamic tables are now only displayed in the main admin page.
    Once entering the sub-pages, the focus is now on the task-at-hand, and the dynamic tables are not displayed.
  * The original (and cluttered) single-page admin layout is still attainable, if you prefer. It is installed via the `OldAdmin` branch.

* Test / Unstable Features (not installed by default)

  * Talker Alias (DMR) displayed next to call sign when operator is transmitting
    (when applicable). This needs a lot of work, yet.  This feature is on the
  `  TalkerAlias` branch. Caveat emptor...this is buggy!

  * Name Look-ups (DMR): First names are displayed next to call sign. There are two versions/two ways this is performed:
    The first is via searching through the Pi-Star DMR ID DB, and the second way, is via the Callook.info API by `W1JDD`.
    The respective name lookup branches are `NameLookups` and `NameLookups-API`. Beware: these are very slow on shitty
    hardware, and requires *lots* of horsepower. Like the `TalkerAlias` feature/branch listed above, these features are
    unstable, and still needs quite a bit of work.

* Much more. See [screenshots below](#screenshots).

## Installing `W0CHP-PiStar-Dash`

1. Make a backup of your configuration - just in case.

2. Open an SSH session to your Pi-Star instance.

3. Run:

        rpi-rw

4. Run:

        curl https://repo.w0chp.net/Chipster/W0CHP-PiStar-Install/raw/master/W0CHP-pistar -o W0CHP-pistar

5. Run this to familiarize yourself with the available options/arguments:

        sudo bash ./W0CHP-pistar -h

    You will be presented with...


        -h,   --help                     Display this help text.
        -id,  --install-dashboard        Install W0CHP dashboard.
        -idc  --install-dashboard-css    Install W0CHP dashboard WITH custom stylesheet.
        -rd,  --restore-dashboard        Restore original dashboard.
        -s,   --status                   Display current install, original or W0CHP installations.

6. When ready to install, run the above command again with the option/argument you wish...e.g:

        sudo bash ./W0CHP-pistar -id

    (...to install the dashboard *without* `W0CHP` CSS).

## Updating `W0CHP-PiStar-Dash`

Once you install `W0CHP-PiStar-Dash`, it will automatically be kept up-to-date
with any new features/versions/etc. This is made possible via the native,
nightly Pi-Star updating process.

## Uninstalling `W0CHP-PiStar-Dash`

Run:

	 sudo bash <path>/W0CHP-pistar -rd

...And the original Pi-Star Dashboard will be restored.

## Notes about CSS, and custom CSS you may have previously applied

1. When using the `-id` option, the "normal" Pi-Star colors are used, and no CSS is installed. Any custom CSS
   you may have had, is removed but backed up. See bullet #4 below.

2. When using the `-idc` option, the `W0CHP` CSS is installed, and any of your custom CSS settings
  before installing the `W0CHP` dashboard, are backed up in the event you want to restore the official dashboard
  (see bullet #4). This is done because the CSS in the official Pi-Star is incompatible. You can still
  manually map/change your CSS back when running `W0CHP-PiStar-Dash` (see bullet #4 for details).

3. If you are already running `W0CHP-PiStar-Dash`, AND you have custom or `W0CHP-PiStar-Dash` CSS, no CSS changes, no matter which
  option you run this command with.

4. When using the `-id` option, your custom CSS settings are backed up (in the event you want to revert back
  to the official dashboard -- see  bullet #6), and the `W0CHP` dashboard uses the standard Pi-Star colors.
  This means that if you want your previous custom CSS applied to the `W0CHP` dashboard, you will need to manually
  customize your colors; You can reference the color values you had previously used, by viewing the backup file of
  your custom CSS...

        /etc/.pistar-css.ini.user

5. ...the reason for bullets #4 and #1, is because the `W0CHP` dashboard is vastly different than the official upstream version
  (completely different CSS mappings). Since this is for my personal use, I haven't added any logic to suck-in
  the user CSS values to the new mappings.

6. If you had customized CSS settings before installing the `W0CHP` dashboard, they will be restored when
  using the `-rd` option.

7. You can at any time start over and reset to the "normal" Pi-Star colors, by performing a CSS Factory Reset (`Configuration -> Expert -> Tools -> CSS Tool`).

## Screenshots

### Main Dashboard

![alt text](https://w0chp.net/img/W0CHP_Dash.png "W0CHP Dashboard")

### Admin Pages

#### Main Admin Landing Page
![alt text](https://w0chp.net/img/W0CHP_Admin_1.png "W0CHP Admin Page 1")

#### "Instant Mode Manager"
![alt text](https://w0chp.net/img/W0CHP_Admin_2.png "W0CHP Admin Page 2")

#### BrandMeister Manager
![alt text](https://w0chp.net/img/W0CHP_Admin_3.png "W0CHP Admin Page 3")

#### TGIF Manager
![alt text](https://w0chp.net/img/W0CHP_Admin_4.png "W0CHP Admin Page 4")

#### YSF Link Manager
![alt text](https://w0chp.net/img/W0CHP_Admin_5.png "W0CHP Admin Page 5")

#### POCSAG / DAPNET Messenger
![alt text](https://w0chp.net/img/W0CHP_Admin_6.png "W0CHP Admin Page 6")

### Dashboard on Mobile Device

![alt text](https://w0chp.net/img/W0CHP_Mobile.png "W0CHP Mobile Page")

### Configuration Page

This image is too enormous to embed here, but you can [view it separately](https://w0chp.net/img/W0CHP_Config.png).

## Credits

[Listed here...](https://w0chp.net/w0chp-pistar-dash/#credits)
