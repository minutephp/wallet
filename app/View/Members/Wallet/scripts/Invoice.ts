/// <reference path="E:/var/Dropbox/projects/siteexplainer/public/static/bower_components/minute/_all.d.ts" />

module App {
    export class InvoiceController {
        constructor(public $scope: any, public $minute: any, public $ui: any, public $timeout: ng.ITimeoutService,
                    public gettext: angular.gettext.gettextFunction, public gettextCatalog: angular.gettext.gettextCatalog) {

            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            $scope.log = $scope.logs[0];
        }

        print = () => {
            let mywindow = window.open('', 'PRINT', 'height=400,width=600');

            mywindow.document.write('<html><head><title>Proforma Invoice</title>');
            mywindow.document.write('<link rel="stylesheet" href="/static/bower_components/bootstrap/dist/css/bootstrap.css" type="text/css" />');
            mywindow.document.write('</head><body>');
            mywindow.document.write('<h1>' + document.title + '</h1>');
            mywindow.document.write(document.getElementById('invoice').innerHTML);

            mywindow.document.close(); // necessary for IE >= 10
            mywindow.focus(); // necessary for IE >= 10*/

            mywindow.onload = () => {
                mywindow.print();
                mywindow.close();
            };

            return true;
        }
    }

    angular.module('InvoiceApp', ['MinuteFramework', 'gettext'])
        .controller('InvoiceController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', InvoiceController]);
}
