import { createRoot } from 'react-dom/client';
import React from 'react';
import IsolatedBlockEditor, {
    EditorLoaded,
    DocumentSection,
    ToolbarSlot,
} from '@automattic/isolated-block-editor';

document.addEventListener('DOMContentLoaded', function () {
    const container = document.querySelector('#editor');
    if (container) {
        const root = createRoot(container);
        root.render(
            <IsolatedBlockEditor
                settings={settings}
                onSaveContent={(html) => saveContent(html)}
                onLoad={(parse) => {
                    if (typeof parse === 'function') {
                        try {
                            parse();
                        } catch (error) {
                            console.error('Error loading content:', error);
                        }
                    }
                }}
                onError={() => setTimeout(() => document.location.reload(), 1000)}
            >
                <EditorLoaded onLoaded={() => {}} onLoading={() => {}} />
                <DocumentSection>Extra Information</DocumentSection>
                <ToolbarSlot>
                    <button>Beep!</button>
                </ToolbarSlot>
            </IsolatedBlockEditor>
        );
    } else {
        console.error('Elemen #editor tidak ditemukan di DOM');
    }
});
