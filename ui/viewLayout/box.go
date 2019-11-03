package viewLayout

import "github.com/jroimartin/gocui"

type box struct {
	name     string
	parent   *box
	leftBox  *box
	rightBox *box
	elements [] *box
	width    int
	height   int
	view *gocui.View
}

func (b *box) SetView(view *gocui.View) {
	b.view = view
}

func (b *box) SetBackgroundColor(backgroundColor gocui.Attribute) {
	b.view.BgColor = backgroundColor
}

func (b *box) GetRightBox() *box {
	return b.rightBox
}

func (b *box) SetRightBox(rightBox *box) {
	b.rightBox = rightBox
}

func (b *box) GetLeftBox() *box {
	return b.leftBox
}

func (b *box) SetLeftBox(left *box) {
	b.leftBox = left
}


func NewBox(name string, width int, height int) *box {
	return &box{name: name, width: width, height: height}
}

func (b *box) SetElements(elements [] *box) *box {
	b.elements = elements

	return b
}

func (b *box) GetHeight() int {
	return b.height
}

func (b *box) SetHeight(height int) {
	b.height = height
}

func (b *box) GetWidth() int {
	return b.width
}

func (b *box) SetWidth(width int) {
	b.width = width
}
func (b *box) GetElements() [] *box {
	return b.elements
}

func (b* box) GetPositionX() int {
	if (b.leftBox == nil) {
		return 0;
	}

	return b.leftBox.GetPositionX() + b.leftBox.GetWidth();
}

func (b* box) GetPositionY() int {
	if (b.parent == nil) {
		return 0;
	}

	return b.parent.GetPositionY() + b.parent.GetHeight();
}

func (b *box) AddElement(element *box) *box {
	if (len(b.elements) > 0) {
		leftElement := b.elements[len(b.elements) - 1]
		element.SetLeftBox(leftElement)
	}
	b.elements = append(b.elements, element)

	return element
}

func (b *box) GetName() string  {
	return b.name;
}