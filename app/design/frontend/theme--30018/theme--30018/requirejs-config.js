// File: app/design/frontend/Vendor/theme/requirejs-config.js
var config = {
 'shim': {
 'js/customjs': {
 'deps': ['js/tt_slideshow'],
 },
 'js/customjs': {
 'deps': ['js/tt_animation'],
 }
 } ,
 deps: [
 'jquery/ui',
 'js/bootstrap.min',
 'js/tt_animation',
'js/tt_slideshow'
,
 'js/customjs',
 'js/html5shiv'
,
 'js/totop'
]
};
