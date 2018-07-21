{"version":3,"sources":["item.js"],"names":["BX","namespace","TileGrid","Item","options","this","id","isDraggable","isDroppable","name","type","layout","container","checkbox","gridTile","dblClickDelay","prototype","bindEvents","addCustomEvent","window","getId","render","clickTimer","preventClick","create","attrs","className","dataset","children","getCheckBox","content","getContent","events","dblclick","event","clearTimeout","handleDblClick","call","resetSetMultiSelectMode","resetSelectAllItems","resetFromToItems","bind","click","setTimeout","handleClick","dragger","registerItem","registerDrop","afterRender","focusItem","resetFocusItem","grid","isKeyControlKey","setMultiSelectMode","checkItem","getFirstCurrentItem","isLastSelectedItem","isMultiSelectMode","unSelectItem","getCurrentItem","setFirstCurrentItem","isKeyPressedShift","selectFromToItems","isKeyPressedSelectAll","checked","selectItem","setCurrentItem","unCheckItem","selected","handleEnter","getContainer","props","stopPropagation","setAttribute","focus","removeAttribute","removeNode","itemContainer","classList","add","style","width","offsetWidth","parentNode","removeChild","animateNode","remove"],"mappings":"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","file":""}