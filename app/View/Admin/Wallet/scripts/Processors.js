/// <reference path="../../../../../../../../public/static/bower_components/minute/_all.d.ts" />
var Admin;
(function (Admin) {
    var ProcessorConfigController = (function () {
        function ProcessorConfigController($scope, $minute, $ui, $timeout, gettext, gettextCatalog) {
            var _this = this;
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$timeout = $timeout;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            this.save = function () {
                _this.$scope.config.save(_this.gettext('Processors updated successfully'));
            };
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            $scope.data = { processors: [], tabs: {} };
            $scope.config = $scope.configs[0] || $scope.configs.create().attr('type', 'wallet').attr('data_json', {});
            $scope.settings = $scope.config.attr('data_json');
            $scope.settings.processors = angular.isObject($scope.settings.processors) ? $scope.settings.processors : {};
        }
        return ProcessorConfigController;
    }());
    Admin.ProcessorConfigController = ProcessorConfigController;
    angular.module('processorConfigApp', ['MinuteFramework', 'AdminApp', 'gettext'])
        .controller('processorConfigController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', ProcessorConfigController]);
})(Admin || (Admin = {}));
