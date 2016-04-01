# dashing-performance-monitor
widget for dashing that let you check some stats of your linux server



Just clone this into your dashing folder:
- `dashing new performance_monitor`
- `cd performance_monitor/dashboard`
- `cd performance_monitor`
- `git clone https://github.com/Clevero/dashing-performance-monitor.git dashboards`
- edit BaseController.php, and fill in your $TOKEN and $HOST infos `$EDITOR BaseController.php`
- start it with `dashing start -a 192.168.122.1` <- replace 192.168.122.1 with your IP mentioned in step above. This setting is 
useful when you just want to access it in your local network (in my case I build a ssh tunnel and open the dashboard 
in my browser with proxy settings)

Have fun!


Please also checkout the awesome [Performance Monitor](https://github.com/Sonelli/juicessh-performancemonitor) for android! It was the main inspiration for my project.
