import { SelectOption } from "@/contracts/base";

export function enumToSelectOptions(enumItem: any): SelectOption {
    if (typeof enumItem !== 'object') {
        throw new Error('Parameter is not enum!');
    }

    const result: SelectOption[] = [];
    for (const key in enumItem) {
        result.push({ key: key, value: enumItem[key] });
    }

    return result;
}
