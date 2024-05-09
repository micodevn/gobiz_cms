<?php
/**
 * @var $permissions
 */

extract($permissions);
$inUserAction = $inUserAction ?? 'default';
function gen_uid($l = 5)
{
    return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, $l);
}

function showRecursive($arr, $currents, $root = '') {
?>
<ul <?= $root === true ? 'id="permission-root"' : '' ?>>
    <?php
    foreach ($arr as $key => $value) {
        $id = gen_uid();
        $path = is_string($root) ? $root . '.' . $key : $key;

        $permissionAttr = count($value) == 0 ? "value=${path} name=permissions[]" : "";
    ?>
    <li>
        <input {{$permissionAttr}} id="per-{{$id}}" type="checkbox" {{in_array($path, $currents) ? 'checked' : ''}}>
        <label for="per-{{$id}}">
            {{__($key)}}
        </label>
        <?php
        if (count($value) != 0) {
            showRecursive($value, $currents, $path);
        }
        ?>
    </li>
    <?php
    }
    ?>
</ul>
<?php
}
?>


<style>
    #permission-root {
        display: grid;
        grid-template-columns: 50% 50%;
        grid-gap: 10px;
        list-style: none;
        padding-left: 0;
    }

    #permission-root ul li {
        list-style: none;
    }

    #permission-root li input, #permission-root li label {
        cursor: pointer;
        user-select: none;
        font-weight: normal;
    }
</style>
<div class="permission-group-container">
    <div class="row">
        <div class="col">
            <label>Danh sách quyền</label>
        </div>
    </div>
    <?php
    showRecursive($allExtract, $currents, true);
    ?>
</div>
@push('page_scripts')
    <script>
        const inUserAction = "{{$inUserAction}}";
        function check(ele) {
            var checked = $(ele).prop("checked"),
                container = $(ele).parent(),
                siblings = container.siblings();

            container.find('input[type="checkbox"]').prop({
                indeterminate: false,
                checked: checked
            });

            function checkSiblings(el) {
                var parent = el.parent().parent(),
                    all = true;

                el.siblings().each(function () {
                    let returnValue = all = ($(this).children('input[type="checkbox"]').prop("checked") === checked);
                    return returnValue;
                });

                if (all && checked) {
                    parent.children('input[type="checkbox"]').prop({
                        indeterminate: false,
                        checked: checked
                    });
                    checkSiblings(parent);
                } else if (all && !checked) {
                    parent.children('input[type="checkbox"]').prop("checked", checked);
                    parent.children('input[type="checkbox"]').prop("indeterminate", (parent.find('input[type="checkbox"]:checked').length > 0));
                    checkSiblings(parent);
                } else {
                    el.parents("li").children('input[type="checkbox"]').prop({
                        indeterminate: true,
                        checked: false
                    });
                }
            }

            checkSiblings(container);
        }

        window.addEventListener('DOMContentLoaded', function () {
            (function ($) {
                $('input[type="checkbox"]').change(function (e) {
                    const ele = e.target;
                    check(ele);
                });

                $('#permission-root > li').each(function (idx, ele) {
                    inUserAction !== 'default' && $(ele).find('input').prop("disabled","disabled");
                    var $target = $(ele).children(),
                        $next = $target;
                    while ($next.length) {
                        $target = $next;
                        $next = $next.children();
                    }

                    $($target).trigger('change');
                });

                $("select#roles").change(function (e) {
                    const options = $(this).find('option:selected');
                    let permissions = [];
                    options.each(function (idx, ele) {
                        permissions = permissions.concat($(ele).data('permissions'));
                    });

                    console.log(permissions);
                });

                $("select#roles").on('select2:unselect', function (e) {
                    const removed = $(e.params.data.element);
                    const permissions = removed.data('permissions');
                    permissions.forEach(function (permission) {
                        const input = $("#permission-root").find(`input[value="${permission}"]`);
                        if (!input[0].double_check || $("select#roles").val().length <= 0) {
                            input.prop('checked', false);
                        }
                        input.trigger('change');
                    });

                });

                $("select#roles").on('select2:select', function (e) {
                    const removed = $(e.params.data.element);

                    const permissions = removed.data('permissions');

                    const parents = $("#permission-root").find('li:has(ul)');

                    for(let i=0; i < parents.children().length ; i ++)
                    {
                        setTimeout(() => {
                            if ($(parents[i]).find('input').prop('checked')) {
                                $(parents[i]).find('input').prop('disabled','disabled');
                            }

                        },300)
                    }

                    permissions.forEach(function (permission) {
                        const input = $("#permission-root").find(`input[value="${permission}"]`);
                        if (input[0].checked == true) {
                            input.prop('double_check', true);
                        }
                        input.prop('checked', true);
                        input.trigger('change');
                    });
                    block = $("#permission-root").find(`input`);
                    block.prop('disabled','disabled')
                    block.trigger('change');
                });
            })(jQuery);
        });
    </script>
@endpush
