@php
    $request = request();
@endphp
<div class="app-sidebar">
    <div class="scrollbar-sidebar">
        <div class="branding-logo">
            @if (getSettings('dark_mode') == 0)
                <img src="{{ getSettings('logo_path') ? asset(getSettings('logo_path')) : asset('public/logo/logo.png') }}"
                    alt="">
            @elseif (getSettings('dark_mode') == 1)
                <img src="{{ getSettings('dark_logo_path') ? asset(getSettings('dark_logo_path')) : asset('public/logo/dark-logo.png') }}"
                    alt="">
            @endif
        </div>
        <div class="branding-logo-forMobile">
            <a href="{{ route('root') }}">
                <img src="{{ getSettings('small_logo_path') ? asset(getSettings('small_logo_path')) : asset('public/logo/small-logo.png') }}"
                    alt="Small Logo">
            </a>
        </div>
        <div class="app-sidebar-inner">
            <ul class="vertical-nav-menu">
                @can('root')
                    <li>
                        <a class="menu {{ $request->routeIs('root') ? 'active' : '' }}" href="{{ route('root') }}">
                            <span>
                                <img src="{{ asset('public/icons/menu.svg') }}" class="menu-icon" alt="icon" />
                                {{ __('dashboard') }}
                            </span>
                        </a>
                    </li>
                @endcan
                @canany(['category.index', 'product.index', 'barcode.print', 'brand.index', 'unit.index', 'tax.index',
                    'warehouse.index'])
                    <li>
                        <a class="menu {{ $request->routeIs('category.*', 'product.*', 'tax.*', 'barcode.print', 'unit.*', 'brand.*') ? 'active' : '' }}"
                            data-bs-toggle="collapse" href="#productMenu">
                            <span>
                                <img src="{{ asset('public/icons/product.svg') }}" class="menu-icon" alt="icon" />
                                {{ __('product') }}
                            </span>
                            <img src="{{ asset('public/icons/arrowDown.svg') }}" alt="" class="downIcon">
                        </a>
                        <div class="collapse dropdownMenuCollapse {{ $request->routeIs('category.*', 'product.*', 'tax.*', 'barcode.print', 'unit.*', 'brand.*') ? 'show' : '' }}"
                            id="productMenu">
                            <div class="listBar">
                                @can('category.index')
                                    <a href="{{ route('category.index') }}"
                                        class="subMenu {{ $request->routeIs('category.index') ? 'active' : '' }}">
                                        {{ __('categories') }}
                                    </a>
                                @endcan
                                @can('category.subcategories')
                                    <a href="{{ route('category.subcategories') }}"
                                        class="subMenu {{ $request->routeIs('category.subcategories') ? 'active' : '' }}">
                                        {{ __('subcategories') }}
                                    </a>
                                @endcan
                                @can('product.index')
                                    <a href="{{ route('product.index') }}"
                                        class="subMenu {{ $request->routeIs('product.*') ? 'active' : '' }}">
                                        {{ __('products') }}
                                    </a>
                                @endcan
                                @can('barcode.print')
                                    <a href="{{ route('barcode.print') }}"
                                        class="subMenu {{ $request->routeIs('barcode.print') ? 'active' : '' }}">
                                        {{ __('print_barcode') }}
                                    </a>
                                @endcan
                                @can('unit.index')
                                    <a href="{{ route('unit.index') }}"
                                        class="subMenu {{ $request->routeIs('unit.index') ? 'active' : '' }}">{{ __('units') }}</a>
                                @endcan
                                @can('brand.index')
                                    <a href="{{ route('brand.index') }}"
                                        class="subMenu {{ $request->routeIs('brand.index') ? 'active' : '' }}">{{ __('brands') }}</a>
                                @endcan
                                @can('tax.index')
                                    <a href="{{ route('tax.index') }}"
                                        class="subMenu {{ $request->routeIs('tax.index') ? 'active' : '' }}">{{ __('taxs') }}</a>
                                @endcan
                            </div>
                        </div>
                    </li>
                @endcanany
                @canany(['purchase.index', 'purchase.create', 'purchase.batch', 'warehouse.index'])
                    <li>
                        <a class="menu {{ $request->routeIs(['purchase.*', 'warehouse.*']) ? 'active' : '' }}"
                            data-bs-toggle="collapse" href="#purchaseMenu">
                            <span>
                                <img src="{{ asset('public/icons/purchase.svg') }}" class="menu-icon" alt="icon" />
                                {{ __('purchase') }}
                            </span>
                            <img src="{{ asset('public/icons/arrowDown.svg') }}" alt="" class="downIcon">
                        </a>
                        <div class="collapse dropdownMenuCollapse {{ $request->routeIs('purchase.*', 'warehouse.*') ? 'show' : '' }}"
                            id="purchaseMenu">
                            <div class="listBar">
                                @can('purchase.index')
                                    <a class="subMenu {{ $request->routeIs('purchase.index', 'purchase.edit') ? 'active' : '' }}"
                                        href="{{ route('purchase.index') }}">{{ __('purchases') }}</a>
                                @endcan
                                @can('purchase.create')
                                    <a class="subMenu {{ $request->routeIs('purchase.create') ? 'active' : '' }}"
                                        href="{{ route('purchase.create') }}">{{ __('add_purchase') }}</a>
                                @endcan
                                @can('purchase.batch')
                                    <a class="subMenu {{ $request->routeIs('purchase.batch') ? 'active' : '' }}"
                                        href="{{ route('purchase.batch') }}">{{ __('batches') }}</a>
                                @endcan
                                @can('warehouse.index')
                                    <a href="{{ route('warehouse.index') }}"
                                        class="subMenu {{ $request->routeIs('warehouse.index') ? 'active' : '' }}">{{ __('warehouses') }}</a>
                                @endcan
                            </div>
                        </div>
                    </li>
                @endcanany
                @canany(['account.index', 'money.transfer.index', 'account.balancesheet'])
                    <li>
                        <a class="menu {{ $request->routeIs('account.*', 'money.transfer.*') ? 'active' : '' }}"
                            data-bs-toggle="collapse" href="#accountMenu">
                            <span>
                                <img src="{{ asset('public/icons/account.svg') }}" class="menu-icon" alt="icon" />
                                {{ __('accounting') }}
                            </span>
                            <img src="{{ asset('public/icons/arrowDown.svg') }}" alt="" class="downIcon">
                        </a>
                        <div class="collapse dropdownMenuCollapse {{ $request->routeIs('account.*', 'money.transfer.*') ? 'show' : '' }}"
                            id="accountMenu">
                            <div class="listBar">
                                @can('account.index')
                                    <a href="{{ route('account.index') }}"
                                        class="subMenu {{ $request->routeIs('account.index') ? 'active' : '' }}">{{ __('accounts') }}</a>
                                @endcan
                                @can('money.transfer.index')
                                    <a href="{{ route('money.transfer.index') }}"
                                        class="subMenu {{ $request->routeIs('money.transfer.index') ? 'active' : '' }}">
                                        {{ __('money_transfer') }}
                                    </a>
                                @endcan
                                @can('account.balancesheet')
                                    <a href="{{ route('account.balancesheet') }}"
                                        class="subMenu {{ $request->routeIs('account.balancesheet') ? 'active' : '' }}">
                                        {{ __('balance_sheet') }}
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </li>
                @endcanany
                @canany(['sale.index', 'sale.draft', 'sale.orders'])
                    <li>
                        <a class="menu {{ $request->routeIs(['sale.index', 'sale.draft', 'sale.orders']) ? 'active' : '' }}"
                            data-bs-toggle="collapse" href="#saleMenu">
                            <span>
                                <img src="{{ asset('public/icons/Activity.svg') }}" class="menu-icon" alt="icon" />
                                {{ __('sales') }}
                            </span>
                            <img src="{{ asset('public/icons/arrowDown.svg') }}" alt="" class="downIcon">
                        </a>
                        <div class="collapse dropdownMenuCollapse {{ $request->routeIs(['sale.index', 'sale.draft', 'sale.orders']) ? 'show' : '' }}"
                            id="saleMenu">
                            <div class="listBar">

                                @can('sale.orders')
                                    <a href="{{ route('sale.orders') }}"
                                        class="subMenu {{ $request->routeIs('sale.orders') ? 'active' : '' }}">
                                        {{ __('orders') }}
                                    </a>
                                @endcan
                                @can('sale.index')
                                    <a href="{{ route('sale.index') }}"
                                        class="subMenu {{ $request->routeIs('sale.index') ? 'active' : '' }}">
                                        {{ __('sales') }}
                                    </a>
                                @endcan
                                @can('sale.draft')
                                    <a href="{{ route('sale.draft') }}"
                                        class="subMenu {{ $request->routeIs('sale.draft') ? 'active' : '' }}">
                                        {{ __('drafts') }}
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </li>
                @endcanany
                @canany(['sale.return.index'])
                    <li>
                        <a class="menu {{ $request->routeIs('sale.return.index') ? 'active' : '' }}"
                            data-bs-toggle="collapse" href="#saleReturnsMenu">
                            <span>
                                <img src="{{ asset('public/icons/return.svg') }}" class="menu-icon" alt="icon" />
                                {{ __('returns') }}
                            </span>
                            <img src="{{ asset('public/icons/arrowDown.svg') }}" alt="" class="downIcon">
                        </a>
                        <div class="collapse dropdownMenuCollapse {{ $request->routeIs('sale.return.index') ? 'show' : '' }}"
                            id="saleReturnsMenu">
                            <div class="listBar">
                                @can('sale.return.index')
                                    <a href="{{ route('sale.return.index') }}"
                                        class="subMenu {{ $request->routeIs('sale.return*') ? 'active' : '' }}">
                                        {{ __('sales') }}
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </li>
                @endcanany
                @canany(['expenseCategory.index', 'expense.index'])
                    <li>
                        <a class="menu {{ $request->routeIs('expenseCategory.*', 'expense.*') ? 'active' : '' }}"
                            data-bs-toggle="collapse" href="#expenseMenu">
                            <span>
                                <img src="{{ asset('public/icons/money-dollar.svg') }}" class="menu-icon"
                                    alt="icon" />
                                {{ __('expense') }}
                            </span>
                            <img src="{{ asset('public/icons/arrowDown.svg') }}" alt="" class="downIcon">
                        </a>
                        <div class="collapse dropdownMenuCollapse {{ $request->routeIs('expenseCategory.*', 'expense.*') ? 'show' : '' }}"
                            id="expenseMenu">
                            <div class="listBar">
                                @can('expenseCategory.index')
                                    <a href="{{ route('expenseCategory.index') }}"
                                        class="subMenu {{ $request->routeIs('expenseCategory.*') ? 'active' : '' }}">
                                        {{ __('expense_category') }}
                                    </a>
                                @endcan
                                @can('expense.index')
                                    <a href="{{ route('expense.index') }}"
                                        class="subMenu {{ $request->routeIs('expense.*') ? 'active' : '' }}">
                                        {{ __('expense') }}
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </li>
                @endcanany
                @canany(['department.index', 'employee.index', 'role.index', 'attendance.index', 'holiday.index',
                    'payroll.index'])
                    <li>
                        <a class="menu {{ $request->routeIs('department.*', 'role.index', 'employee.*', 'attendance.*', 'holiday.*', 'payroll.*') ? 'active' : '' }}"
                            data-bs-toggle="collapse" href="#departmentMenu">
                            <span>
                                <img src="{{ asset('public/icons/user-polygon.svg') }}" class="menu-icon"
                                    alt="icon" />
                                {{ __('hrm') }}
                            </span>
                            <img src="{{ asset('public/icons/arrowDown.svg') }}" alt="" class="downIcon">
                        </a>
                        <div class="collapse dropdownMenuCollapse {{ $request->routeIs('department.*', 'role.*', 'employee.*', 'attendance.*', 'holiday.*', 'payroll.*') ? 'show' : '' }}"
                            id="departmentMenu">
                            <div class="listBar">
                                @can('department.index')
                                    <a href="{{ route('department.index') }}"
                                        class="subMenu {{ $request->routeIs('department.*') ? 'active' : '' }}">
                                        {{ __('departments') }}
                                    </a>
                                @endcan
                                @can('role.index')
                                    <a href="{{ route('role.index') }}"
                                        class="subMenu {{ $request->routeIs('role.*') ? 'active' : '' }}">
                                        {{ __('role_permission') }}
                                    </a>
                                @endcan
                                @can('employee.index')
                                    <a href="{{ route('employee.index') }}"
                                        class="subMenu {{ $request->routeIs('employee.*') ? 'active' : '' }}">
                                        {{ __('employees') }}
                                    </a>
                                @endcan
                                @can('attendance.index')
                                    <a href="{{ route('attendance.index') }}"
                                        class="subMenu {{ $request->routeIs('attendance.*') ? 'active' : '' }}">
                                        {{ __('attendance') }}
                                    </a>
                                @endcan
                                @can('payroll.index')
                                    <a href="{{ route('payroll.index') }}"
                                        class="subMenu {{ $request->routeIs('payroll.*') ? 'active' : '' }}">
                                        {{ __('payrolls') }}
                                    </a>
                                @endcan
                                @can('holiday.index')
                                    <a href="{{ route('holiday.index') }}"
                                        class="subMenu {{ $request->routeIs('holiday.*') ? 'active' : '' }}">
                                        {{ __('holidays') }}
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </li>
                @endcanany
                @canany(['customer.index', 'supplier.index', 'customer.group.index'])
                    <li>
                        <a class="menu {{ $request->routeIs('customer.*', 'supplier.*', 'customer.group.*') ? 'active' : '' }}"
                            data-bs-toggle="collapse" href="#peopleMenu">
                            <span>
                                <img src="{{ asset('public/icons/users.svg') }}" class="menu-icon" alt="icon" />
                                {{ __('people') }}
                            </span>
                            <img src="{{ asset('public/icons/arrowDown.svg') }}" alt="" class="downIcon">
                        </a>
                        <div class="collapse dropdownMenuCollapse {{ $request->routeIs('customer.*', 'supplier.*', 'customer.group.*') ? 'show' : '' }}"
                            id="peopleMenu">
                            <div class="listBar">
                                @can('customer.index')
                                    <a href="{{ route('customer.index') }}"
                                        class="subMenu {{ $request->routeIs(['customer.index', 'customer.edit', 'customer.create']) ? 'active' : '' }}">
                                        {{ __('customers') }}
                                    </a>
                                @endcan
                                @can('customer.group.index')
                                    <a href="{{ route('customer.group.index') }}"
                                        class="subMenu {{ $request->routeIs('customer.group.index') ? 'active' : '' }}">
                                        {{ __('customer_groups') }}
                                    </a>
                                @endcan
                                @can('supplier.index')
                                    <a href="{{ route('supplier.index') }}"
                                        class="subMenu {{ $request->routeIs('supplier.*') ? 'active' : '' }}">
                                        {{ __('suppliers') }}
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </li>
                @endcanany
                @canany(['report.summary', 'report.profit.loss', 'report.purchases', 'report.sales', 'report.product',
                    'report.expense'])
                    <li>
                        <a class="menu {{ $request->routeIs('report.*') ? 'active' : '' }}" data-bs-toggle="collapse"
                            href="#reportMenu">
                            <span>
                                <img src="{{ asset('public/icons/report.svg') }}" class="menu-icon" alt="icon" />
                                {{ __('reports') }}
                            </span>
                            <img src="{{ asset('public/icons/arrowDown.svg') }}" alt="" class="downIcon">
                        </a>
                        <div class="collapse dropdownMenuCollapse {{ $request->routeIs('report.*') ? 'show' : '' }}"
                            id="reportMenu">
                            <div class="listBar">
                                @can('report.summary')
                                    <a href="{{ route('report.summary') }}"
                                        class="subMenu {{ $request->routeIs('report.summary') ? 'active' : '' }}">
                                        {{ __('summary') }}
                                    </a>
                                @endcan
                                @can('report.profit.loss')
                                    <a href="{{ route('report.profit.loss') }}"
                                        class="subMenu {{ $request->routeIs('report.profit.loss') ? 'active' : '' }}">
                                        {{ __('profit_loss') }}
                                    </a>
                                @endcan
                                @can('report.purchases')
                                    <a href="{{ route('report.purchases') }}"
                                        class="subMenu {{ $request->routeIs('report.purchases') ? 'active' : '' }}">
                                        {{ __('purchases') }}
                                    </a>
                                @endcan
                                @can('report.sales')
                                    <a href="{{ route('report.sales') }}"
                                        class="subMenu {{ $request->routeIs('report.sales') ? 'active' : '' }}">
                                        {{ __('sales') }}
                                    </a>
                                @endcan
                                @can('report.product')
                                    <a href="{{ route('report.product') }}"
                                        class="subMenu {{ $request->routeIs('report.product') ? 'active' : '' }}">
                                        {{ __('products') }}
                                    </a>
                                @endcan
                                @can('report.expense')
                                    <a href="{{ route('report.expense') }}"
                                        class="subMenu {{ $request->routeIs('report.expense') ? 'active' : '' }}">
                                        {{ __('expense') }}
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </li>
                @endcanany
                @can('banner.index')
                    <li>
                        <a class="menu {{ $request->routeIs('banner.index') ? 'active' : '' }}"
                            href="{{ route('banner.index') }}">
                            <span>
                                <img src="{{ asset('public/icons/banner.svg') }}" class="menu-icon" alt="icon" />
                                {{ __('banners') }}
                            </span>
                        </a>
                    </li>
                @endcan
                @can('coupon.index')
                    <li>
                        <a class="menu {{ $request->routeIs('coupon.index') ? 'active' : '' }}"
                            href="{{ route('coupon.index') }}">
                            <span>
                                <img src="{{ asset('public/icons/coupon.svg') }}" class="menu-icon" alt="icon" />
                                {{ __('coupons') }}
                            </span>
                        </a>
                    </li>
                @endcan
                @canany(['currency.index', 'profile.index', 'settings.index'])
                    <li>
                        <a class="menu {{ $request->routeIs('currency.*', 'profile.*', 'settings.*') ? 'active' : '' }}"
                            data-bs-toggle="collapse" href="#SettingMenu">
                            <span>
                                <img src="{{ asset('public/icons/Setting.svg') }}" class="menu-icon" alt="icon" />
                                {{ __('settings') }}
                            </span>
                            <img src="{{ asset('public/icons/arrowDown.svg') }}" alt="" class="downIcon">
                        </a>
                        <div class="collapse dropdownMenuCollapse {{ $request->routeIs('currency.*', 'profile.*', 'settings.*') ? 'show' : '' }}"
                            id="SettingMenu">
                            <div class="listBar">
                                @can('currency.index')
                                    <a href="{{ route('currency.index') }}"
                                        class="subMenu {{ $request->routeIs('currency.index') ? 'active' : '' }}">{{ __('currencies') }}</a>
                                @endcan
                                @can('profile.index')
                                    <a href="{{ route('profile.index') }}"
                                        class="subMenu {{ $request->routeIs('profile.index') ? 'active' : '' }}">{{ __('profile') }}</a>
                                @endcan
                                @can('mail.configuration.index')
                                    <a href="{{ route('mail.configuration.index') }}"
                                        class="subMenu {{ $request->routeIs('mail.configuration.index') ? 'active' : '' }}">{{ __('smtp_configure') }}</a>
                                @endcan
                                @can('settings.index')
                                    <a href="{{ route('settings.index') }}"
                                        class="subMenu {{ $request->routeIs('settings.index') ? 'active' : '' }}">{{ __('aplication_settings') }}</a>
                                @endcan
                                @can('database.backup')
                                    <a href="#" id="databaseDownloadConfirm"
                                        class="subMenu">{{ __('data_base_backup') }}</a>
                                @endcan
                            </div>
                        </div>
                    </li>
                @endcanany
                @can('language.index')
                    <li>
                        <a class="menu {{ $request->routeIs('language.*') ? 'active' : '' }}"
                            href="{{ route('language.index') }}">
                            <span>
                                <img src="{{ asset('public/icons/language.svg') }}" class="menu-icon" alt="icon" />
                                {{ __('language') }}
                            </span>
                        </a>
                    </li>
                @endcan
                {{-- Logout --}}
                <li>
                    <a class="menu" href="{{ route('signout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <span>
                            <img src="{{ asset('public/icons/logout.svg') }}" class="menu-icon" alt="Logout Icon">
                            {{ __('logout') }}
                        </span>
                    </a>
                    <form id="logout-form" action="{{ route('signout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
