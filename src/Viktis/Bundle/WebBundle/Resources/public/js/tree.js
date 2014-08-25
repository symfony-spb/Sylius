$(function () {
    $('.tree li:has(ul)').addClass('parent_li').find(' > span').attr('title', 'Collapse this branch');
    $('.tree li.parent_li > span').on('click', function (e) {
        var children = $(this).parent('li.parent_li').find(' > ul > li');
        if (children.is(":visible")) {
            children.hide('fast');
            $(this).attr('title', 'Разверните').find(' > i').addClass('icon-folder-close').removeClass('icon-folder-open');
        } else {
            children.show('fast');
            $(this).attr('title', 'Сверните').find(' > i').addClass('icon-folder-open').removeClass('icon-folder-close');
        }
        e.stopPropagation();
    });
});