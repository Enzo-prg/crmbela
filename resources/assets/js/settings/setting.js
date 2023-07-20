'use strict';

$(document).on('submit', '#settingUpdate', function () {

    if (groupName === 'company_information') {
        let address = $('#addressId').val();
        let companyName = $('#companyNameId').val();

        let emptyAddress = address.trim().replace(/ \r\n\t/g, '') === '';
        if (emptyAddress) {
            displayErrorMessage(
                'Address field is not contain only white space');
            return false;
        }

        let emptyCompanyName = companyName.trim().replace(/ \r\n\t/g, '') ===
            '';
        if (emptyCompanyName) {
            displayErrorMessage(
                'Company Name field is not contain only white space');
            return false;
        }
    }

    if (groupName === 'general') {
        let applicationName = $('#applicationNameId').val();
        let emptyApplicationName = applicationName.trim().
            replace(/ \r\n\t/g, '') === '';

        if (emptyApplicationName) {
            displayErrorMessage(
                'Application Name field is not contain only white space');
            return false;
        }
    }

    if ($('#error-msg').text() !== '') {
        $('#phoneNumber').focus();
        return false;
    }
});

$(document).on('change', '#logo', function () {
    if (isValidFile($(this), '#validationErrorsBox')) {
        displayPhoto(this, '#logoPreview');
    }
});

$(document).on('change', '#favicon', function () {
    if (isValidFile($(this), '#validationErrorsBox')) {
        displayFavicon(this, '#faviconPreview');
    }
});
