import { forEach } from "lodash";

export default class MyEnum {

    constructor(values)
    {
        this.values = values;
    }

    get_all()
    {

        return this.values;

    }

    get_all_as_list_of_object()
    {

        let list = [];

        let keys = _.keys(this.values);

        keys.forEach(key => {

            list.push({

                id: this.get_value(key),
                name: key,

            });

        });

        return list;

    }

    get_value(key)
    {

        try
        {
            return this.values[key];
        }
        catch
        {
            return null;
        }

    }

    get_key(value)
    {

        try
        {
            return this.swap(this.values)[value];
        }
        catch
        {
            return null;
        }

    }

    swap(json){
        var ret = {};
        for(var key in json){
            ret[json[key]] = key;
        }
        return ret;
    }

}
