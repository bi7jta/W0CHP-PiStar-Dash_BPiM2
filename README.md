# ABOUT

**DO NOT contact me for support, bugs, etc...**

This is my *personal* and highly customized PiStar dashboard, and related
binaries, forked from F1RMB, which was forked from MW0MWZ's original code.  I
offer ZERO support. This is here for your hacking and enjoyment, and you're
fully on your own.

**If you ask me for support, I will ignore you; and possibly mock you on [my
website](https://w0chp.net) for not following very simple instructions.**

## To install the `W0CHP` Pi-Star Dashboard

1. Open an SSH session to your Pi-Star instance.

2. Run:

```text
rpi-rw
```

3. Run:

```text
curl https://repo.w0chp.net/Chipster/W0CHP-PiStar-Install/raw/master/W0CHP-pistar -o W0CHP-pistar
```
4. Run:

```text
sudo bash ./W0CHP-pistar -h
```
...to familiarize yourself with the available options/arguments:

```text
-h,   --help                     Display this help text.
-ia,  --install-all              Install W0CHP dashboard, styelsheet, binaries and system binaries
-ra,  --restore-all              Restore original dashboard, binaries and system binaries
-id,  --install-dashboard        Install W0CHP dashboard.
-idn  --install-dashboard-nocss  Install W0CHP dashboard WITHOUT Stylesheet.
-rd,  --restore-dashboard        Restore original dashboard.
-ib,  --install-binaries         Install W0CHP binaries.
-rb,  --restore-binaries         Restore original binaries.
-is,  --install-sbinaries        Install W0CHP system binaries.
-rs,  --restore-sbinaries        Restore original system binaries.
-s,   --status                   Display current install, original or W0CHP installations.
```

5. When ready to install, run the above command again with the option/argument you wish...e.g:

```text
sudo bash ./W0CHP-pistar -id
```

(...to install the dashboard only).

6. Enjoy! :-)

## Notes about custom CSS you may have applied to the official PiStar Dashboard

  * When using the `-id` or `-ia` options, the W0CHP CSS is installed, and any of your custom CSS settings
    before installing the W0CHP dashboard, are backed up in the event you want to restore the official dashboard
    (see last bullet point).
  * When using the `-idn` option, your custom CSS settings are backed up (in the event you want to revert back
    to the official dashboard -- see last bullet point), and the W0CHP dashboard uses the standard PiStar colors.
    This means that if you want your previous custom CSS applied the W0CHP dashboard, you will need to manually
    customize your colors; You can reference the color values you had previously used, by viewing the backup file of
    your custom CSS...

    ```text
    /etc/.pistar-css.ini.user
    ```

  * ...the reason for this, is because the W0CHP dashboard is vastly different than the official upstream version
    (completely different CSS mappings). Since this is for my personal use, I haven't added any logic to suck in
    the user CSS values to the new mappings.
  * If you had customized CSS settings before installing the W0CHP dashboard, they will be restored when
    using the `-ra` or `-rd` options.

## Screenshots

![alt text](https://w0chp.net/img/W0CHP-Dash.png "Screenshot Green")

![alt text](https://w0chp.net/img/W0CHP-Dash_1.png "Screenshot Blue")

