var Questionnaire = Questionnaire || {};

Questionnaire.init = function () {
    this.render();
}

Questionnaire.render = function () {
    $.ajax(Routing.generate('extra_questionnaire', {'_locale': locale}), {
        success: function (data) {
            $('#section_questionnaire').html(data);
            Questionnaire.submit();
        }
    });
}

Questionnaire.submit = function () {
    $('#questionnaireFormSubmitBtn').click(function () {
        $.ajax({
            type: "POST",
            url: Routing.generate('extra_questionnaire', {'_locale': locale}),
            data: $("#questionnaire_form").serialize(),
            success: function (data) {
                $('#section_questionnaire').html(data);
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#formQuestionnaire").offset().top
                }, 2000);
                Questionnaire.submit();
            }
        });

    });
}
