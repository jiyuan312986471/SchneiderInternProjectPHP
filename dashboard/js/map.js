/*
 * MAP Object
 *
 * Interface��
 * size()     						get number of elements
 * isEmpty()    					check if MAP is empty
 * clear()     						delete all elements in MAP
 * put(key, value)   			put new element into map
 * remove(key)    				delete element corresponding to the key, return true if success, false is failed
 * get(key)    						get element by key, return value of element if success, NULL if failed
 * element(index)   			get element by index(use element.key & element.value to get KEY and VALUE), return value of element if success, NULL if failed
 * containsKey(key)  			check if MAP contains element corresponding to the key
 * containsValue(value) 	check if MAP contains element having indicated value
 * values()    						return an array contains all values of the MAP
 * keys()     						return an array contains all keys of the MAP
 *
 * Example:
 * var map = new Map();
 *
 * map.put("key", "value");
 * var val = map.get("key")
 * ����
 *
 */
function Map() {
    this.elements = new Array();
 
    // get number of elements
    this.size = function() {
        return this.elements.length;
    }
 
    // check if MAP is empty
    this.isEmpty = function() {
        return (this.elements.length < 1);
    }
 
    // delete all elements in MAP
    this.clear = function() {
        this.elements = new Array();
    }
 
    // put new element into map
    this.put = function(_key, _value) {
        this.elements.push( {
            key : _key,
            value : _value
        });
    }
 
    // delete element corresponding to the key, return true if success, false is failed
    this.remove = function(_key) {
        var bln = false;
        try {
            for (i = 0; i < this.elements.length; i++) {
                if (this.elements[i].key == _key) {
                    this.elements.splice(i, 1);
                    return true;
                }
            }
        } catch (e) {
            bln = false;
        }
        return bln;
    }
 
    // get element by key, return value of element if success, NULL if failed
    this.get = function(_key) {
        try {
            for (i = 0; i < this.elements.length; i++) {
                if (this.elements[i].key == _key) {
                    return this.elements[i].value;
                }
            }
        } catch (e) {
            return null;
        }
    }
 
    // get element by index(use element.key & element.value to get KEY and VALUE), return value of element if success, NULL if failed
    this.element = function(_index) {
        if (_index < 0 || _index >= this.elements.length) {
            return null;
        }
        return this.elements[_index];
    }
 
    // check if MAP contains element corresponding to the key
    this.containsKey = function(_key) {
        var bln = false;
        try {
            for (i = 0; i < this.elements.length; i++) {
                if (this.elements[i].key == _key) {
                    bln = true;
                }
            }
        } catch (e) {
            bln = false;
        }
        return bln;
    }
 
    // check if MAP contains element having indicated value
    this.containsValue = function(_value) {
        var bln = false;
        try {
            for (i = 0; i < this.elements.length; i++) {
                if (this.elements[i].value == _value) {
                    bln = true;
                }
            }
        } catch (e) {
            bln = false;
        }
        return bln;
    }
 
    // return an array contains all values of the MAP
    this.values = function() {
        var arr = new Array();
        for (i = 0; i < this.elements.length; i++) {
            arr.push(this.elements[i].value);
        }
        return arr;
    }
 
    // return an array contains all keys of the MAP
    this.keys = function() {
        var arr = new Array();
        for (i = 0; i < this.elements.length; i++) {
            arr.push(this.elements[i].key);
        }
        return arr;
    }
}