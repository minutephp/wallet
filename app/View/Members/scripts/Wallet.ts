/// <reference path="../../../../../../../public/static/bower_components/minute/_all.d.ts" />

module App {
    export class WalletListController {
        constructor(public $scope: any, public $minute: any, public $ui: any, public $timeout: ng.ITimeoutService,
                    public gettext: angular.gettext.gettextFunction, public gettextCatalog: angular.gettext.gettextCatalog) {

            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');

            $scope.config = $scope.configs[0] || {data_json: {}};
            $scope.settings = $scope.config.data_json;
        }

    }

    angular.module('walletListApp', ['MinuteFramework', 'MembersApp', 'gettext'])
        .controller('walletListController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', WalletListController]);
}