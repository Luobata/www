(UserAgent = function () {
    
    var getUa = function () {
        var ua = navigator.userAgent.toLowerCase(),
            Sys = {},
            s,
            log;
        (s = ua.match(/rv:([\d.]+)\) like gecko/)) ? Sys.ie = s[1] :
        (s = ua.match(/msie ([\d.]+)/)) ? Sys.ie = s[1] :
        (s = ua.match(/firefox\/([\d.]+)/)) ? Sys.firefox = s[1] :
        (s = ua.match(/crios\/([\d.]+)/)) ? Sys.mobile_chrome = s[1] :
        (s = ua.match(/micromessenger\/([\d.]+)/)) ? Sys.mobile_wechat = s[1] :
        (s = ua.match(/opr\/([\d.]+)/)) ? Sys.opera = s[1] :
        (s = ua.match(/opera.([\d.]+)/)) ? Sys.opera = s[1] :
        (s = ua.match(/chrome\/([\d.]+)/)) ? Sys.chrome = s[1] :
        (s = ua.match(/version\/([\d.]+).*safari/)) ? Sys.safari = s[1] : 0;

        if (Sys.ie) log = ('IE: ' + Sys.ie);
        if (Sys.firefox) log = ('Firefox: ' + Sys.firefox);
        if (Sys.mobile_chrome) log = ('mobile_chrome: ' + Sys.mobile_chrome);
        if (Sys.mobile_wechat) log = ('mobile_wechat: ' + Sys.mobile_wechat);
        if (Sys.chrome) log = ('Chrome: ' + Sys.chrome);
        if (Sys.opera) log = ('Opera: ' + Sys.opera);
        if (Sys.safari) log = ('Safari: ' + Sys.safari);

        document.getElementById('ua').innerText = log;

        return log;
    }

    return getUa();
})();