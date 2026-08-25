property pSprite
global g, gL, gSp

on beginSprite me
  pSprite = sprite(me.spriteNum)
  pSprite.member.text = string(gSp.GAME.mGetNumPhoto(pSprite))
  pSprite.visible = 1
end

on bUpdate me, theNum
  pSprite.member.text = string(theNum)
end

on bHide me
  pSprite.visible = 0
end
