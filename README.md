# ABOUT

This is my personal and highly customized PiStar dashboard, and related binaries, forked from F1RMB, which was forked from MW0MWZ's original code.
I offer ZERO support. This is here for your hacking and enjoyment.

## If you ask me for support, I will ignore you!

## To install the `W0CHP` Pi-Star Dashboard

1. Open an SSH session to your Pi-Star instance.

2. Run:

        rpi-rw
3. Run:

        curl https://repo.cucc.io/Chipster/W0CHP-PiStar-Install/raw/master/W0CHP-pistar -o W0CHP-pistar
4. Run:

        sudo bash ./W0CHP-pistar -h
...to familiarize yourself with the available options/arguments:

        -h,  --help                     Display this help text.
        -ia, --install-all              Install W0CHP dashboard, binaries and system binaries
        -ra, --restore-all              Restore original dashboard, binaries and system binaries
        -id, --install-dashboard        Install W0CHP dashboard.
        -rd, --restore-dashboard        Restore original dashboard.
        -ib, --install-binaries         Install W0CHP binaries.
        -rb, --restore-binaries         Restore original binaries.
        -is, --install-sbinaries        Install W0CHP system binaries.
        -rs, --restore-sbinaries        Restore original system binaries.
        -s,  --status                   Display current install, original or W0CHP installations
5. When ready to install, run the above command again with the option/argument you wish...e.g:

        sudo bash ./W0CHP-pistar -id
(...to install the dashboard only).

6. Enjoy! :-)

## Screenshots

![alt text](http://techdocs.cuccio.us/W0CHP-Dash.png "Screenshot Green")

![alt text](http://techdocs.cuccio.us/W0CHP-Dash_1.png "Screenshot Blue")

