<div class="content-wrapper ng-cloak" ng-app="walletListApp" ng-controller="walletListController as mainCtrl" ng-init="init()">
    <div class="members-content">
        <section class="content-header">
            <h1><span translate="">Your wallet</span> <small><span translate="">transactions</span></small></h1>

            <ol class="breadcrumb">
                <li><a href="" ng-href="/members"><i class="fa fa-dashboard"></i> <span translate="">Members</span></a></li>
                <li class="active"><i class="fa fa-money"></i> <span translate="">Your wallet</span></li>
            </ol>
        </section>

        <section class="content">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <span translate="">All wallets</span>
                    </h3>

                    <div class="box-tools">
                        <a class="btn btn-sm btn-primary btn-flat" ng-href="/wallet/deposit/start">
                            <i class="fa fa-plus-circle"></i> <span translate="">Add money</span>
                        </a>
                    </div>
                </div>

                <div class="box-body">
                    <div class="list-group" ng-if="!wallets.length">
                        <span translate="">Your have not made any transactions in your wallet.</span>
                    </div>
                    <div class="list-group" ng-if="!!wallets.length">
                        <div class="list-group-item list-group-item-bar list-group-item-bar-{{wallet.amount > 0 && 'success' || 'danger'}}"
                             ng-repeat="wallet in wallets" ng-click-container="mainCtrl.actions(wallet)">
                            <div class="pull-left">
                                <h4 class="list-group-item-heading">{{wallet.order.item_name | ucfirst}}</h4>
                                <p class="list-group-item-text hidden-xs">
                                    <span translate="">Date:</span> {{wallet.created_at | timeAgo}}.
                                    <span ng-show="!!wallet.log.transaction_id"><span translate="">Transaction #</span> {{wallet.log.transaction_id}} via {{wallet.order.processor}}.</span>
                                </p>
                            </div>
                            <div class="md-actions pull-right">
                                <h3 class="no-padding no-margin">{{wallet.amount | currency}}</h3>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <div class="row">
                        <div class="col-xs-12 col-md-6 col-md-push-6">
                            <minute-pager class="pull-right" on="wallets" no-results="{{'No transactions found' | translate}}"></minute-pager>
                        </div>
                        <div class="col-xs-12 col-md-6 col-md-pull-6">
                            <minute-search-bar on="wallets" columns="amount,log.subscription_id,log.transaction_id,order.processor,order.item_name"
                                               label="{{'Search wallets..' | translate}}"></minute-search-bar>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
