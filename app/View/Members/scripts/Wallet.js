/// <reference path="../../../../../../../public/static/bower_components/minute/_all.d.ts" />
var App;
(function (App) {
    var WalletListController = (function () {
        function WalletListController($scope, $minute, $ui, $timeout, gettext, gettextCatalog) {
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$timeout = $timeout;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            $scope.config = $scope.configs[0] || { data_json: {} };
            $scope.settings = $scope.config.data_json;
        }
        return WalletListController;
    }());
    App.WalletListController = WalletListController;
    angular.module('walletListApp', ['MinuteFramework', 'MembersApp', 'gettext'])
        .controller('walletListController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', WalletListController]);
})(App || (App = {}));
