import { SelectOption } from "@/contracts/base";

export function enumToSelectOptions(enumItem: any): SelectOption {
    if (typeof enumItem !== 'object') {
        throw new Error('Parameter is not enum!');
    }

    const result: SelectOption[] = [];
    for (const key in enumItem) {
        const value = enumItem[key];
        result.push({ key: value, value: key });
    }

    return result;
}
