<div class="content-wrapper ng-cloak" ng-app="InvoiceApp" ng-controller="InvoiceController as mainCtrl" ng-init="init()" ng-cloak="">

    <div class="members-content">
        <section class="content-header">
            <h1><span translate="">View Invoice</span></h1>

            <ol class="breadcrumb">
                <li><a href="" ng-href="/members"><i class="fa fa-dashboard"></i> <span translate="">Members</span></a></li>
                <li><a href="" ng-href="/members/wallet"><i class="fa fa-money"></i> <span translate="">Payments</span></a></li>
                <li class="active"><i class="fa fa-invoice"></i> <span translate="">Invoice #{{log.wallet_log_id}}</span></li>
            </ol>
        </section>

        <section class="content" ng-switch="!log.order.cart.product.name">
            <div class="box box-solid" ng-switch-when="true">
                <div class="alert alert-warning alert-dismissible" role="alert">
                    Cannot find any products associated with this transaction.
                </div>
            </div>

            <div class="box box-default" ng-switch-default="">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <span translate="">Invoice #{{log.wallet_log_id}}</span>
                    </h3>

                    <div class="box-tools" ng-show="settings.wallet.allowDeposits != false">
                        <a class="btn btn-xs btn-default btn-flat" ng-click="mainCtrl.print()">
                            <i class="fa fa-print"></i> <span translate="">Print</span>
                        </a>
                    </div>
                </div>

                <div class="box-body" id="invoice">
                    <div class="row">
                        <div class="col-xs-8">
                            <p><img ng-src="{{session.site.logo.dark}}" alt="{{session.site.site_name}} Logo"></p>
                            <h3>{{session.site.site_name}}</h3>
                            <p ng-if="config.address">Address: {{config.address}}</p>
                            <p ng-if="config.address">Tax ID: {{config.tax_id}}</p>
                            <p>support@{{session.site.domain}}</p>
                            <p>www.{{session.site.domain}}</p>
                        </div>
                        <div class="col-xs-4">
                            <div class="pull-right">
                                <h1>INVOICE<br><small># {{log.wallet_log_id}}</small></h1>
                                <p>Date: {{log.created_at | date:'MMM dd, yyyy.'}}</p>
                                <p>Due Date: {{log.created_at | date:'MMM dd, yyyy.'}}</p>
                                <p class="text-success">Balance Due: $0</p>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <table class="table">
                        <thead>
                        <tr>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Rate</th>
                            <th>Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <p>{{log.order.cart.product.name}}</p>
                                <p><i>{{log.order.cart.product.description}}</i></p>
                            </td>
                            <td>1</td>
                            <td>{{log.amount | currency}}</td>
                            <td>{{log.amount | currency}}</td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                            <td colspan="2">
                                <p>Subtotal: {{log.amount | currency}}</p>
                                <p>Total: {{log.amount | currency}}</p>
                                <p>Paid: {{log.amount | currency}}</p>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <br>

                    <p>&nbsp;</p>
                    <p align="center">Thank you for your business.</p>
                    <p>&nbsp;</p>
                </div>
            </div>

        </section>
    </div>
</div>
