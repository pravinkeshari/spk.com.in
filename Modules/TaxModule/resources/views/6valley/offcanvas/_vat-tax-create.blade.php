@include("taxmodule::6valley.offcanvas._view-guideline-button")

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasSetupGuide" aria-labelledby="offcanvasSetupGuideLabel"
     data-status="{{ request('offcanvasShow') && request('offcanvasShow') == 'offcanvasSetupGuide' ? 'show' : '' }}">

    <div class="offcanvas-header bg-body">
        <div>
            <h3 class="mb-1">{{ translate('All_VAT/TAX_List') }}</h3>
            <p class="fs-12">{{ translate('this_section_allows_you_to_manage_all_taxes_applied_to_your_products.') }}</p>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body">

        <div class="p-12 p-sm-20 bg-section rounded mb-3 mb-sm-20">
            <div class="d-flex gap-3 align-items-center justify-content-between overflow-hidden">
                <button class="btn-collapse d-flex gap-3 align-items-center bg-transparent border-0 p-0" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapseFirebaseConfig_01" aria-expanded="true">
                    <div class="btn-collapse-icon border bg-light icon-btn rounded-circle text-dark collapsed">
                        <i class="fi fi-sr-angle-right"></i>
                    </div>
                    <span class="fw-bold text-start">{{ translate('What_is_Tax') }} ?</span>
                </button>
            </div>

            <div class="collapse mt-3 show" id="collapseFirebaseConfig_01">
                <div class="card card-body">
                    <p class="fs-12">
                        {{ translate('tax_is_a_mandatory_charge_added_to_a_customer’s_bill_as_per_local_government_regulations.') }}
                    </p>
                    <p class="fs-12">
                        {{ translate('common_types_include_vat_(value_added_tax),_gst_(goods_and_services_tax),_and_income_tax.') }}
                    </p>
                    <p class="fs-12">
                        {{ translate('the_types_and_rates_of_taxes_may_vary_depending_on_the_country_or_region_your_restaurant_operates_in.') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="p-12 p-sm-20 bg-section rounded mb-3 mb-sm-20">
            <div class="d-flex gap-3 align-items-center justify-content-between overflow-hidden">
                <button class="btn-collapse d-flex gap-3 align-items-center bg-transparent border-0 p-0 collapsed" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapseFirebaseConfig_02" aria-expanded="true">
                    <div class="btn-collapse-icon border bg-light icon-btn rounded-circle text-dark collapsed">
                        <i class="fi fi-sr-angle-right"></i>
                    </div>
                    <span class="fw-bold text-start">{{ translate('Why_Set_Up_Taxes') }} ?</span>
                </button>
            </div>

            <div class="collapse mt-3" id="collapseFirebaseConfig_02">
                <div class="card card-body">
                    <p class="fs-12">
                        - {{ translate('ensure_your_restaurant_stays_legally_compliant.') }}
                    </p>
                    <p class="fs-12">
                        - {{ translate('accurately_calculate_charges_on_food,_service,_or_delivery.') }}
                    </p>
                    <p class="fs-12">
                        - {{ translate('automatically_apply_the_correct_rates_during_checkout_and_invoicing.') }}
                    </p>
                    <p class="fs-12">
                        - {{ translate('help_generate_proper_tax_reports_for_your_accounting.') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="p-12 p-sm-20 bg-section rounded mb-3 mb-sm-20">
            <div class="d-flex gap-3 align-items-center justify-content-between overflow-hidden">
                <button class="btn-collapse d-flex gap-3 align-items-center bg-transparent border-0 p-0 collapsed" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapseFirebaseConfig_03" aria-expanded="true">
                    <div class="btn-collapse-icon border bg-light icon-btn rounded-circle text-dark collapsed">
                        <i class="fi fi-sr-angle-right"></i>
                    </div>
                    <span class="fw-bold text-start">{{ translate('VAT/Tax_Edit') }}</span>
                </button>
            </div>

            <div class="collapse mt-3" id="collapseFirebaseConfig_03">
                <div class="card card-body">
                    <p class="fs-12">
                        {{ translate('Once_a_vat/tax_is_added,_its_name_cannot_be_changed_and_it_cannot_be_deleted.') }}
                        {{ translate('Only_the_vat/tax_rate_can_be_updated_later.') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="p-12 p-sm-20 bg-section rounded mb-3 mb-sm-20">
            <div class="d-flex gap-3 align-items-center justify-content-between overflow-hidden">
                <button class="btn-collapse d-flex gap-3 align-items-center bg-transparent border-0 p-0" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapseFirebaseConfig_04" aria-expanded="true">
                    <div class="btn-collapse-icon border bg-light icon-btn rounded-circle text-dark collapsed">
                        <i class="fi fi-sr-angle-right"></i>
                    </div>
                    <span class="fw-bold text-start">{{ translate('List_of_VAT_TAX') }}</span>
                </button>
            </div>

            <div class="collapse mt-3" id="collapseFirebaseConfig_04">
                <div class="card card-body">
                    <p class="fs-12">
                        {{ translate('From_this_list,_you_can_manage_all_your_VAT/Tax_records_in_one_place._Use_the_Export_and_Import_buttons_to_quickly_back_up_or_upload_a_VAT/Tax_list.') }}
                    </p>
                    <p class="fs-12">
                        {{ translate('You_can_also_add_new_entries_by_clicking_the_Create_VAT/Tax_button.') }}
                    </p>
                    <p class="fs-12">
                        {{ translate('Additionally,_each_VAT/Tax_entry_can_be_activated_or_deactivated_at_any_time_by_toggling_its_status_on_or_off.') }}
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>
