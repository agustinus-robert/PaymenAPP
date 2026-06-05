export async function getLayoutsMeta() {
  return await import("./layout/meta.json").then((f) => f.default);
}

export async function getLayoutPages(layoutId: string) {
  const layoutPages = await import("./layout/pages.json").then((f) => f.default);
  const pages = layoutPages.find((l) => l.id === layoutId);

  if (!pages) {
    throw new Error(`Fail to get layout ${layoutId}`);
  }

  return pages;
}

export async function getLayoutPageData(data: { id: string; layoutId: string }) {
  const layouts = await import("./layout/layouts.json").then((f) => f.default);
  const layout = layouts.find((f) => f.id == data.layoutId);

  if (!layout) {
    throw new Error(`Fail to get layout ${data.layoutId}`);
  }

  const page = layout.pages.find((f) => f.id === data.id);

  if (!page) {
    throw new Error(`Fail to get page ${data.id}`);
  }

  return page;
}
