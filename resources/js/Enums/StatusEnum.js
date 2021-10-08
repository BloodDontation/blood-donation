import MyEnum from "./MyEnum";

export default class StatusEnum extends MyEnum {

    constructor()
    {

        super({

            'pending'           :  0,
            'approved'          :  1,
            'rejected'          :  2,

        });

    }

}
