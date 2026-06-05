import { addPageToDataBase } from "@/lib/item/utils";
import { Item } from "./types";

export async function newItem(item: Item): Promise<Item> {
  addPageToDataBase(item);

  return item;
}
