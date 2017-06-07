/// <reference path="E:/var/Dropbox/projects/siteexplainer/public/static/bower_components/minute/_all.d.ts" />
var App;
(function (App) {
    var InvoiceController = (function () {
        function InvoiceController($scope, $minute, $ui, $timeout, gettext, gettextCatalog) {
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$timeout = $timeout;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            this.print = function () {
                var mywindow = window.open('', 'PRINT', 'height=400,width=600');
                mywindow.document.write('<html><head><title>Proforma Invoice</title>');
                mywindow.document.write('<link rel="stylesheet" href="/static/bower_components/bootstrap/dist/css/bootstrap.css" type="text/css" />');
                mywindow.document.write('</head><body>');
                mywindow.document.write('<h1>' + document.title + '</h1>');
                mywindow.document.write(document.getElementById('invoice').innerHTML);
                mywindow.document.close(); // necessary for IE >= 10
                mywindow.focus(); // necessary for IE >= 10*/
                mywindow.onload = function () {
                    mywindow.print();
                    mywindow.close();
                };
                return true;
            };
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            $scope.log = $scope.logs[0];
        }
        return InvoiceController;
    }());
    App.InvoiceController = InvoiceController;
    angular.module('InvoiceApp', ['MinuteFramework', 'gettext'])
        .controller('InvoiceController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', InvoiceController]);
})(App || (App = {}));
