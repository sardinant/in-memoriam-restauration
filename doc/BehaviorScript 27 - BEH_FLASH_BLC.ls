property spriteNum, pS, pSprite, pState
global g, gSp, gL

on new me, iINTpiste
  spriteNum = iINTpiste
  pS = me.spriteNum
  pSprite = sprite(pS)
  pState = #DISP
  pSprite.visible = 1
  pSprite.member = member("FLASH_BC", g.cst.pct)
  pSprite.loc = point(0, 0)
  pSprite.rect = rect(0, 0, 800, 600)
  pSprite.locZ = the maxinteger
  pSprite.blend = 100
  return me
end

on prepareFrame me
  if gAskBusy() then
    case pState of
      #DISP:
        pSprite.blend = max(0, pSprite.blend - (g.frameTime * 200))
        if pSprite.blend = 0 then
          aClearOnePuppet(pSprite)
        end if
    end case
  end if
end
