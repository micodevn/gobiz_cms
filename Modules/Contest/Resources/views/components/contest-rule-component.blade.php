<?php
/** @var $contest */
$contest = $contest ?? new \Modules\Contest\Entities\Contest();

$selectedContestRounds = $contest?->rounds;
?>

<div>
    {!! Form::label('info_detail','Thể lệ cuộc thi') !!}
    <div class="rule_round">
        <table class="table table-bordered" id="detail_round_table">
            <thead>
            <tr>
                <td>Vòng</td>
                <td>Ảnh giải thưởng</td>
                <td>Chi tiết thể lệ vòng</td>
                <td>#</td>
            </tr>
            </thead>
            <tbody>

            @foreach($selectedContestRounds as $selectedContestRound)
                <?php
                $selectedRound = $selectedContestRound->round;
                ?>
                @if($selectedContestRound->prize_round)
                    <?php
                    $iconSelected = $selectedRound->detailFile($selectedContestRound->prize_round);
                    $iconSelected = $iconSelected ? [
                        [
                            'id' => $iconSelected->file_id,
                            'name' => $iconSelected->name,
                        ]
                    ] : [];
                    ?>
                @endif
                <tr>
                    <td>
                        <x-api-select
                            :url="route('round-option')"
                            name="round"
                            emptyValue=""
                            :selected="[$selectedRound]"
                            placeholder="Search round"
                            class="round-list select-list"
                        ></x-api-select>
                    </td>
                    <td>
                        <x-api-select
                            :url="route('api.file.search')"
                            name="prize_round"
                            :fieldSourceAttribute="$sourceField"
                            :selected="$iconSelected"
                            emptyValue=""
                            placeholder="Search ion"
                            class="file-list select-list"
                        ></x-api-select>
                    </td>
                    <td class="d-none">
                        <input type="hidden" name="image_name_prize_round" class="image_name">
                    </td>
                    <td class="d-none">
                        <input type="hidden" name="image_path_prize_round" class="image_path">
                    </td>
                    <td>
                        <label>
                                                        <textarea class="ckedit_init"
                                                                  name="detail_rule_round">{!! $selectedContestRound->detail_rule_round !!}</textarea>
                        </label>
                    </td>
                    <td>
                        <button onclick="removeRow(this)" type="button"
                                class="btn btn-danger">x
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="text-right mt-2">
        <button onclick="addRuleRowForRound()" type="button"
                class="btn btn-outline-secondary btn-sm">+ Add
        </button>
    </div>
</div>
