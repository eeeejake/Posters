$(document).ready(function() {
/*dropdown menu code*/
$('#navbar li').hover(
        function () {
            //show its submenu
            $('ul', this).slideDown(100);
 
        },
        function () {
            //hide its submenu
            $('ul', this).slideUp(100);        
        }
    );
/* end dropdown menu code*/
});

