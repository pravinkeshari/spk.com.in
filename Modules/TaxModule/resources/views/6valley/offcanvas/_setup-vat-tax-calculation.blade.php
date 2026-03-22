@include("taxmodule::6valley.offcanvas._view-guideline-button")

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasSetupGuide" aria-labelledby="offcanvasSetupGuideLabel"
     data-status="{{ request('offcanvasShow') && request('offcanvasShow') == 'offcanvasSetupGuide' ? 'show' : '' }}">

    <div class="offcanvas-header bg-body">
        <div>
            <h3 class="mb-1">{{ translate('Setup_Vat/Tax_Calculation') }}</h3>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body">
        <div class="p-12 p-sm-20 bg-section rounded mb-3 mb-sm-20">
            <div class="d-flex gap-3 align-items-center justify-content-between overflow-hidden">
                <button class="btn-collapse d-flex gap-3 align-items-center bg-transparent border-0 p-0 collapsed" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapseFirebaseConfig_02" aria-expanded="true">
                    <div class="btn-collapse-icon border bg-light icon-btn rounded-circle text-dark collapsed">
                        <i class="fi fi-sr-angle-right"></i>
                    </div>
                    <span class="fw-bold text-start">{{ translate('Tax_Settings') }} </span>
                </button>
            </div>

            <div class="collapse mt-3 show" id="collapseFirebaseConfig_02">
                <div class="card card-body">
                    <p class="fs-12">
                        {{ translate('This_page_allows_you_to_manage_your_entire_tax_configuration_for_the_vendors.') }}
                    </p>
                    <p class="fs-12">
                        {{ translate('accurately_calculate_charges_on_food,_service,_or_delivery.') }}
                    </p>
                    <p class="fs-12">
                        {{ translate('From_enabling_VAT/GST_to_choosing_whether_tax_is_included_in_or_added_to_prices,_you_have_full_control.') }}
                    </p>
                    <p class="fs-12">
                        {{ translate('You_can_apply_taxes_order-wise,_food-wise,_category-wise,_or_even_on_specific_services_like_delivery_and_reservation_fees_ensuring_accurate_and_compliant_billing_across_all_operations.') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="p-12 p-sm-20 bg-section rounded mb-3 mb-sm-20">
            <div class="d-flex gap-3 align-items-center justify-content-between overflow-hidden">
                <button class="btn-collapse d-flex gap-3 align-items-center bg-transparent border-0 p-0 collapsed" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapseFirebaseConfig_04" aria-expanded="true">
                    <div class="btn-collapse-icon border bg-light icon-btn rounded-circle text-dark collapsed">
                        <i class="fi fi-sr-angle-right"></i>
                    </div>
                    <span class="fw-bold text-start">{{ translate('Tax_Calculation_Method') }}</span>
                </button>
            </div>
            <div class="collapse mt-3" id="collapseFirebaseConfig_04">
                <div class="card card-body">
                    <p> {{ translate('Include_in_Food_Price_When_you_select_Calculate_VAT/Tax_Included_in_Food’s_Price:') }}</p>
                    <p class="fs-12">-{{ translate('The_tax_is_already_built_into_the_food_price.') }}</p>
                    <p class="fs-12">-{{ translate('No_separate_tax_line_will_be_shown_on_invoices_or_reports.') }}</p>
                    <p class="fs-12">-{{ translate('VAT_reports_will_not_be_generated_from_these_totals.') }}</p>
                    <p> {{ translate('Exclude_from_Food_Price:') }}</p>
                    <p class="fs-12">-{{ translate('Tax_is_calculated_on_top_of_the_food_price_and_added_as_a_separate_amount.') }}</p>
                    <p class="fs-12">-{{ translate('The_tax_appears_as_a_distinct_line_item_on_bills,_invoices,_and_order_summaries.') }}</p>
                    <p class="fs-12">-{{ translate('Orders_will_show_a_label_like:_"VAT_Included.') }}</p>
                    <p class="fs-12">-{{ translate('This_enables_accurate,_detailed_VAT/GST_reporting_for_compliance_and_accounting.') }}</p>

                </div>
            </div>
        </div>
        <div class="p-12 p-sm-20 bg-section rounded mb-3 mb-sm-20">
            <div class="d-flex gap-3 align-items-center justify-content-between overflow-hidden">
                <button class="btn-collapse d-flex gap-3 align-items-center bg-transparent border-0 p-0 collapsed" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapseFirebaseConfig_05" aria-expanded="true">
                    <div class="btn-collapse-icon border bg-light icon-btn rounded-circle text-dark collapsed">
                        <i class="fi fi-sr-angle-right"></i>
                    </div>
                    <span class="fw-bold text-start">{{ translate('Flexible_Tax_Application_Options') }}</span>
                </button>
            </div>

            <div class="collapse mt-3" id="collapseFirebaseConfig_05">
                <div class="card card-body">
                    <p> {{ translate('Tax_can_be_applied_with_flexibility_depending_on_business_needs:') }}</p>
                    <p>-{{ translate('The_tax_is_already_built_into_the_food_price.') }}</p>
                    <p class="fs-12">-{{ translate('Order_Wise_Tax:_One_tax_rate_applied_to_the_entire_order_total.') }}</p>
                    <p class="fs-12">-{{ translate('Product_Wise_Tax:_Different_tax_rates_applied_individually_per_product_item.') }}</p>
                    <p class="fs-12">-{{ translate('Category_Wise_Tax:_Taxes_vary_by_food_category.') }}</p>
                </div>
            </div>
        </div>
        <div class="p-12 p-sm-20 bg-section rounded mb-3 mb-sm-20">
            <div class="d-flex gap-3 align-items-center justify-content-between overflow-hidden">
                <button class="btn-collapse d-flex gap-3 align-items-center bg-transparent border-0 p-0 collapsed" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapseFirebaseConfig_06" aria-expanded="true">
                    <div class="btn-collapse-icon border bg-light icon-btn rounded-circle text-dark collapsed">
                        <i class="fi fi-sr-angle-right"></i>
                    </div>
                    <span class="fw-bold text-start">{{ translate('Set_Tax_Rates') }}</span>
                </button>
            </div>
            <div class="collapse mt-3" id="collapseFirebaseConfig_06">
                <div class="card card-body">
                    <p> {{ translate('Choose_between_applying_a_flat_tax_rate_across_all_income_types_or_configuring_income-specific_rates_for_product_and_delivery_charge.') }}</p>
                   <p>{{translate('Local_tax_rates_(e.g.,_VAT_7.5%,_GST_5%)_should_be_input_accordingly')}}</p>
                </div>
            </div>
        </div>
    </div>
</div>


