/// <reference path="../../../../../../../../public/static/bower_components/minute/_all.d.ts" />
var Admin;
(function (Admin) {
    var WalletConfigController = (function () {
        function WalletConfigController($scope, $minute, $ui, $timeout, gettext, gettextCatalog) {
            var _this = this;
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$timeout = $timeout;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            this.save = function () {
                _this.$scope.config.save(_this.gettext('Wallet saved successfully'));
            };
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            $scope.data = { processors: [], tabs: {} };
            $scope.config = $scope.configs[0] || $scope.configs.create().attr('type', 'wallet').attr('data_json', {});
            $scope.settings = $scope.config.attr('data_json');
            $scope.settings.wallet = angular.isObject($scope.settings.wallet) ? $scope.settings.wallet : { allowDeposits: true };
        }
        return WalletConfigController;
    }());
    Admin.WalletConfigController = WalletConfigController;
    angular.module('walletConfigApp', ['MinuteFramework', 'AdminApp', 'gettext'])
        .controller('walletConfigController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', WalletConfigController]);
})(Admin || (Admin = {}));
