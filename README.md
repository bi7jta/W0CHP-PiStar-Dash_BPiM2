## About `W0CHP-PiStar-Dash`, and Some Warnings

**DO NOT contact me for support, bugs, etc...**

This is my *personal* and highly customized Pi-Star dashboard, and related
binaries.  I offer ZERO support. This is here for your hacking and enjoyment,
and you're fully on your own. *Use at your own risk*, and DO NOT ask me for
support.  Nor should you file/report any bugs etc. on any official Pi-Star
medium...this is not an oficial Pi-Star release.

If you ask me to support, **I will ignore you.**

## Features and enhancements (not an exhaustive list)

* Updated UI elements galore, styling, wider, bigger, and mobile-friendly. Better fonts (no MS font references here!).

* More Last Heard rows displayed (40 vs. 20).

* BrandMeister Manager revamps galore:

  * Now displays connected actual talkgroup names.

  * Reflector functionality removed per <https://news.brandmeister.network/brandmeister-dmr-reflectors-support-ending-by-end-of-2020/>.

  * Connected dynamic talkgroups now display idle-timeout time (due to no TX).

  * Added ability to mass-drop your static talkgroups; and mass re-add the previously
    linked static talkgroups.

   * Added ability to batch add/delete up to 5 static talkgroups at a time (for now)

* TGIF Manager; now displays connected actual talkgroup names.

* "Instant Mode Manager" added to admin page; allows you to instantly pause or resume selected radio modes. Handy for attending
  nets, quieting a busy mode, to temporarily eliminate "mode monopolization", etc.

* DMR JitterTest and related form added.

* RF activity moved to top on dashboard.

* YSF link manager now enabled for YSF2DMR mode as well; gives the ability to change links/rooms on-the-fly.

* Connected FCS and YSF reflector names and numerical ID both displayed in dashboard left panel.

* Ability to configure POCSAG hangtime from the config page.

* Additional hardware and system information displayed in top header.

* Better dashboard mobile device view.

* Talker Alias (DMR) displayed next to callsign when operator is transmitting
  (when applicable). This needs a lot of work, yet.  (This is on the
  `TalkerAlias` branch, and needs to be explicitly be installed/defined - caveat
  emptor...this is buggy!).

* Admin page split up into logical sub-sections/sub-pages, in order to present
  better feedback messages when making changes. This is still in dev/testing, and
  requires you to install the `NewAdmin` branch until the features are eventually
  merged into `master`.

* Much more. See [screenshots below](#screenshots).

## Installing `W0CHP-PiStar-Dash`

1. Open an SSH session to your Pi-Star instance.

2. Run:

        rpi-rw

3. Run:

        curl https://repo.w0chp.net/Chipster/W0CHP-Pi-Star-Install/raw/master/W0CHP-pistar -o W0CHP-pistar

4. Run this to familiarize yourself with the available options/arguments:

        sudo bash ./W0CHP-pistar -h

    You will be presented with...


        -h,   --help                     Display this help text.
        -id,  --install-dashboard        Install W0CHP dashboard.
        -idn  --install-dashboard-nocss  Install W0CHP dashboard WITHOUT stylesheet.
        -rd,  --restore-dashboard        Restore original dashboard.
        -s,   --status                   Display current install, original or W0CHP installations.

5. When ready to install, run the above command again with the option/argument you wish...e.g:

        sudo bash ./W0CHP-pistar -id

(...to install the dashboard with `W0CHP` CSS).

## Updating `W0CHP-PiStar-Dash`

Once you install `W0CHP-PiStar-Dash`, it will automatically be kept up-to-date
with any new features/versions/etc. This is made possible via the native,
nightly Pi-Star updating process.

## Uninstalling `W0CHP-PiStar-Dash`

Run:

	 sudo bash <path>/W0CHP-pistar -rd

...And the original Pi-Star Dashboard will be restored.

## Notes about CSS, and custom CSS you may have previously applied

1. When using the `-idn` option, the "normal" Pi-Star colors are used, and no CSS is installed.

2. When using the `-id` option, the `W0CHP` CSS is installed, and any of your custom CSS settings
  before installing the `W0CHP` dashboard, are backed up in the event you want to restore the official dashboard
  (see bullet #4). This is done because the CSS in the official Pi-Star is incompatible. You can still
  manually map/change your CSS back when running `W0CHP-PiStar-Dash` (see  bullet #4 for details).

3. If you are already running `W0CHP-PiStar-Dash`, AND you have custom or `W0CHP-PiStar-Dash` CSS, no CSS changes, no matter which
  option you run this command with.

4. When using the `-idn` option, your custom CSS settings are backed up (in the event you want to revert back
  to the official dashboard -- see  bullet #6), and the `W0CHP` dashboard uses the standard Pi-Star colors.
  This means that if you want your previous custom CSS applied to the `W0CHP` dashboard, you will need to manually
  customize your colors; You can reference the color values you had previously used, by viewing the backup file of
  your custom CSS...

        /etc/.pistar-css.ini.user

5. ...the reason for this, is because the `W0CHP` dashboard is vastly different than the official upstream version
  (completely different CSS mappings). Since this is for my personal use, I haven't added any logic to suck-in
  the user CSS values to the new mappings.

6. If you had customized CSS settings before installing the `W0CHP` dashboard, they will be restored when
  using the `-rd` option.


## Screenshots

### Main Dashboard

(click for larger image)

![alt text](https://w0chp.net/img/W0CHP_Dash.png "W0CHP Dashboard")

### Admin Page

(click for larger image)

![alt text](https://w0chp.net/img/W0CHP_Admin.png "W0CHP Admin Page")

### Dashboard on Mobile Device

(click for larger image)

![alt text](https://w0chp.net/img/W0CHP_Mobile.png "W0CHP Mobile Page")

### Configuration Page

This image is too enormous to embed here, but you can [view it separately](https://w0chp.net/img/W0CHP_Config.png).

## Credits

[Listed here...](https://w0chp.net/w0chp-pistar-dash/#credits)
