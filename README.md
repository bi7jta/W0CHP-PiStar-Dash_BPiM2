## About `W0CHP-PiStar-Dash`, and Some Warnings

This is my *personal* and highly customized fork/version of the Pi-Star
dashboard, and related binaries.  I offer ZERO support. This is here for your
hacking and enjoyment, and you're fully on your own. *Use at your own risk*,
and DO NOT ask me for support.  Nor should you file/report any bugs etc. on any
official Pi-Star medium...this is not an official Pi-Star release.

It's *strongly* recommended that you read and heed the [rules and
caveats](https://w0chp.net/w0chp-pistar-dash/#rules).

Users of `W0CHP-PiStar-Dash` are on [Module **E** of
XLX493](https://w0chp.net/articles/wpsd-support-on-xlx493/). If you're lucky;
and if I'm in a good mood and/or if my availability allows, I can help on there
too. A very easy way to connect to the support reflector, is via BrandMeister DMR,
TalkGroup `3170603`.

## Installing `W0CHP-PiStar-Dash`

**Note: You need to have a Pi-Star hotspot running at least v4.1.6!**

1. Make a backup of your configuration if you wish -- just in case.

2. Open an SSH session to your Pi-Star instance.

3. Run this to familiarize yourself with the available options/arguments:

    ```text
    curl -Ls https://w0chp.net/WPSD-Install | sudo env NO_SELF_UPDATE=1 bash -s -- -h
    ```

    You will be presented with...


        [i] W0CHP PiStar-Dash Installer Command Usage:

          -h,   --help                  :  Display this help text.


          -id,  --install-dashboard     :  Install W0CHP dashboard.


          -idc  --install-dashboard-css :  Install W0CHP dashboard,
                                           WITH custom stylesheet.

          -rd,  --restore-dashboard     :  Restore original dashboard.


          -s,   --status                :  Display current install; original,
                                           or W0CHP installations.

4. When ready to install, run the above command again with the option/argument you wish...e.g:

    ```text
    curl -Ls https://w0chp.net/WPSD-Install | sudo env NO_SELF_UPDATE=1 bash -s -- -id
    ```

    (...to install the dashboard *without* the `W0CHP` custom CSS)

5. Important: You **must** run the aforementioned commands with the exact syntax. Note the spaces and extra `--` (dashes), etc.
   Otherwise, the commands will fail.

## Updating `W0CHP-PiStar-Dash`

Once you install `W0CHP-PiStar-Dash`, it will automatically be kept up-to-date
with any new features/versions/etc. This is made possible via the native,
nightly Pi-Star updating process.

You can also manually invoke the update process via the dashboard admin section
(`Admin -> Update`), or by command line:

```text
sudo pistar-update
```

## Uninstalling `W0CHP-PiStar-Dash`

Run:

```text
 curl -Ls https://w0chp.net/WPSD-Install | sudo env NO_SELF_UPDATE=1 bash -s -- -rd
```

...And the original Pi-Star Dashboard will be restored.

## Installation Demo Video

[See how easy it is to install...](https://w0chp.net/musings/wpsd-install-demo/)

## Features, Enhancements and Omissions (not an exhaustive list)

* Updated user interface elements galore, styling, wider, bigger, updated fonts, etc.

* Full M17 Protocol Support.

* Full APRSGateway Support: Selectable APRS Data Sharing with specific modes.

* Full DGId Support.

* Selectable DMR Roaming Beacon Support: Network or Interval Mode (or disabled).

* "Live Caller" screen; similar to a "virtual Nextion screen"; displays current caller information in real-time.

* Current/Last Caller Details on Main Dashboard (name/location, when available).

* Improved and graphical CSS/color styling configuration page; easily change the look and feel of the dashboard.

* User-Configurable number of displayed Last Heard dashboard rows (defaults to 40, and 100 is the maximum).

* User-Configurable font size for most of the pertinent dashboard information.

* Reorganized and sectioned configuration page for better usability.

* XLX Hosts are now searchable/selectable in DMR Master selection in configuration page.

* System process status reorganized into clean grid pattern, with more core service status being displayed.

* User-Configurable 24 or 12 hour time display across the dashboard.

* Searchable drop-downs for massive host lists in configuration/admin pages. E.g. YSF Hosts, XLX Hosts, DMR Hosts, etc.

* BrandMeister Manager revamps galore:

  * Now displays connected actual talk group names.

  * Reflector functionality removed per [BrandMeister's announcement](https://news.brandmeister.network/brandmeister-dmr-reflectors-support-ending-by-end-of-2020/).

  * Connected dynamic talk groups now display idle-timeout time (due to no TX).

  * Added ability to mass-drop your static talk groups; and mass re-add the previously
    linked static talk groups.

   * Added ability to batch add/delete up to 5 static talk groups at a time (for now)

* TGIF Manager; now displays connected actual talk group names. (**NOTE**: Since TGIF has moved to a new platform with no API available, this currently does not work until TGIF's API is made avaiable.)

* "Instant Mode Manager" added to admin page; allows you to instantly pause or resume selected radio modes. Handy for attending
  nets, quieting a busy mode, to temporarily eliminate "mode monopolization", etc.

* "System Manager" added to admin page; allows you to instantly:

  * Disable / Enable the intrusive and slow Pi-Star Firewall.
  
  * Disable / Enable Cron, in order to prevent updates and Pi-Star services restarting during middle-of-the-night/early AM operation.

* YSF link manager gives the ability to change links/rooms on-the-fly, rather than going through the large (and slow) configuration page.

* Connected FCS and YSF reflector names and numerical ID both displayed in dashboard left panel.

* Ability to configure POCSAG hang-time from the config page.

* Additional hardware and system information displayed in top header.

* Admin page split up into logical sub-sections/sub-pages, in order to present
  better feedback messages when making changes.
  * Note: Last-Heard and other dynamic tables are now only displayed in the main admin page.
    Once entering the sub-pages, the focus is now on the task-at-hand, and the dynamic tables are not displayed.

* Much more. See [screenshots below](#screenshots).

### Features in Official Pi-Star Which are Intentionally Omitted in `W0CHP-PiStar-Dash`

* Upgrade notice/nag in header (unnecessary and a hacky implementation). This has been replaced by my own
  unobtrusive dashboard update notifier; displayed in the upper-right hand side of the top header.

* "GPS" link in Call Sign column of dashboard (superfluous and unreliable).

* Selectable Call Sign link to either QRZ.com or RadioID.com (both services
  suck, and the implementation of this feature is poor and unintuitive. Left
  the original function linking to QRZ.com).

* CPU Temp. in header; when CPU is running "cool" or "normal" recommended temps, the cell background
  is no longer colored green. Only when the CPU is running beyond recommended temps, is the cell colored
  orange or red.

* No reboot/shutdown nag screen/warning from admin page (Superfluous; you
  click it, it will reboot/shutdown without warning.).

* Yellow DMR Mode cell in left panel when there's a DMR network password/login
  issue (poor/inaccurate and taxing implementation, and can confuse power users that
  utilize my Instant Mode Manager, where the default cell is amber colored for
  paused modes [color is user-configurable].).

	Instead, the *actual* network name is highlighted in red when there's a login issue (courtesy of F1RMB's excellent code).

## Notes about CSS, and custom CSS you may have previously applied

1. When using the `-id` option, the "normal" Pi-Star colors are used, and no CSS is installed. Any custom CSS
   you may have had, is removed but backed up. See bullet 4 below.

2. When using the `-idc` option, the `W0CHP` CSS is installed, and any of your custom CSS settings
  before installing the `W0CHP` dashboard, are backed up in the event you want to restore the official dashboard
  (see bullet 4). This is done because the CSS in the official Pi-Star is incompatible. You can still
  manually map/change your CSS back when running `W0CHP-PiStar-Dash` (see bullet 4 for details).

3. If you are already running `W0CHP-PiStar-Dash`, AND you have custom or `W0CHP-PiStar-Dash` CSS, no CSS changes, no matter which
  option you run this command with.

4. When using the `-id` option, your custom CSS settings are backed up (in the event you want to revert back
  to the official dashboard -- see  bullet 6), and the `W0CHP` dashboard uses the standard Pi-Star colors.
  This means that if you want your previous custom CSS applied to the `W0CHP` dashboard, you will need to manually
  customize your colors; You can reference the color values you had previously used, by viewing the backup file of
  your custom CSS...

        /etc/.pistar-css.ini.user

5. ...the reason for bullets 4 and 1, is because the `W0CHP` dashboard is vastly different than the official upstream version
  (completely different CSS mappings). Since this is for my personal use, I haven't added any logic to suck-in
  the user CSS values to the new mappings.

6. If you had customized CSS settings before installing the `W0CHP` dashboard, they will be restored when
  using the `-rd` option.

7. You can at any time start over and reset to the "normal" Pi-Star colors, by performing a CSS Factory Reset (`Configuration -> Expert -> Tools -> CSS Tool`).

8. If you'd like to start over with the custom `W0CHP` colors/CSS, you can copy/paste the following into your `/etc/pistar-css.ini`:

    ```ini
    [Background]
    PageColor=#212529
    ContentColor=#212529
    BannersColor=#2e363f
    NavbarColor=#2e363f
    NavbarHoverColor=#65737e
    DropdownColor=#6b6c73
    DropdownHoverColor=#3c3f47
    ServiceCellActiveColor=#0e790e
    ServiceCellInactiveColor=#9b3d3d
    ModeCellDisabledColor=#535353
    ModeCellActiveColor=#0e790e
    ModeCellInactiveColor=#9b3d3d
    ModeCellPausedColor=#a75808
    NavPanelColor=#212529
    TableRowBgEvenColor=#949494
    TableRowBgOddColor=#7a7c80

    [Text]
    TextColor=#000000
    TextSectionColor=#bebebe
    TextLinkColor=#1a2573
    TableHeaderColor=#bebebe
    BannersColor=#bebebe
    NavbarColor=#bebebe
    NavbarHoverColor=#ffffff
    DropdownColor=#ffffff
    DropdownHoverColor=#ffffff
    ServiceCellActiveColor=#ffffff
    ServiceCellInactiveColor=#bebebe
    ModeCellDisabledColor=#b3b3af
    ModeCellActiveColor=#ffffff
    ModeCellInactiveColor=#bebebe

    [ExtraSettings]
    TableBorderColor=#3c3f47
    LastHeardRows=40
    MainFontSize=18
    HeaderFontSize=34
    BodyFontSize=17
    ```

## Screenshots

Not all pages shown here. Note, that you can customize the colors to your preferences...

### Main Dashboard
![alt text](https://w0chp.net/img/WPSD_Dashboard.png "W0CHP Dashboard")

### Main Admin Landing Page
![alt text](https://w0chp.net/img/WPSD_Admin.png "W0CHP Admin Page")

### BrandMeister Manager
![alt text](https://w0chp.net/img/WPSD_BMman.png "W0CHP BrandMeister Manager")

### Live Caller Screen
![alt-text](https://w0chp.net/img/WPSD_LC.png "Live Caller Screen")

## Credits

[Listed here...](https://w0chp.net/w0chp-pistar-dash/#credits)

