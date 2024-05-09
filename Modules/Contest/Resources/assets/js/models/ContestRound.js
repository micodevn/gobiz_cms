import BaseModel from './BaseModel';

class ContestRound extends BaseModel {
    constructor(props) {
        super(props);
        if (this.type_filter === null) {
            this.type_filter = 0;
        }

        this.FILTER_TYPE_WHITELIST = 1;
        this.FILTER_TYPE_BLACKLIST = 2;

        this.typeFilterOptions = {
            0 : {
                id: 0,
                name: 'All'
            },
            1 : {
                id: this.FILTER_TYPE_WHITELIST,
                name: 'White List'
            },
            2 : {
                id: this.FILTER_TYPE_BLACKLIST,
                name: 'Black List'
            },
        };

        this.typeUserCandidate = {
            1 : {
                id: 1,
                name: 'Đăng ký thành công'
            },
            2 : {
                id: 2,
                name: 'Đăng ký chưa hoàn tất'
            }
        }
    }

    useBlackList() {
        return this.type_filter === this.FILTER_TYPE_BLACKLIST;
    }

    useWhiteList() {
        return this.type_filter === this.FILTER_TYPE_WHITELIST;
    }

    getFilterList() {
        if (this.useBlackList()) {
            return this.user_black_list;
        }

        if (this.useWhiteList()) {
            return this.user_white_list;
        }

        return null;
    }

    getTypeFilterOption() {
        console.log(this.type_filter);
        return this.typeFilterOptions[this.type_filter];
    }
}

export default ContestRound;
