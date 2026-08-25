property ancestor, pListEvent
global g, gL, gSp

on new me
  (the actorList).add(me)
  me.ancestor = new(script("PS_SOUND_ANCESTOR"))
  me.mInitSoundTracks([#VOICE: [1], #MUSIK: [2, 3, 4], #SFX: [5, 6, 7, 8]])
  pListEvent = [#PHOTO: VOID]
  return me
end

on stepFrame me
  me.mStepframe()
end

on mMsgSFX me, iSYMevent, iLSPparam
  case iSYMevent of
    #NEXTLEVEL:
      me.mLaunchMUSIK([#member: "BO_AmbLoop01", #loop: 1])
      me.mLaunchMUSIK([#member: "BO_AmbLoop02", #loop: 1])
      me.mLaunchMUSIK([#member: "BO_AmbLoop03", #loop: 1])
    #rollover:
      vNum = string(iLSPparam[#num])
      if vNum.char.count = 1 then
        vNum = "0" & vNum
      end if
      vStr = "BO_Rollover" & vNum
      me.mLaunchSFX([#member: vStr])
    #VALID:
      me.mLaunchSFX([#member: "BO_Valid01"])
    #TAKE:
      me.mLaunchSFX([#member: "BO_Take01"])
    #RELEASE1:
      me.mLaunchSFX([#member: "BO_Release01"])
    #RELEASE2:
      me.mLaunchSFX([#member: "BO_Release02"])
    #UNVALID:
      me.mLaunchSFX([#member: "BO_UnValid01"])
    #PHOTO_ON:
      if not voidp(pListEvent.PHOTO) then
        exit
      end if
      pListEvent.PHOTO = me.mLaunchSFX([#member: "BO_PhotoLoop", #loop: 1])
    #PHOTO_OFF:
      if voidp(pListEvent.PHOTO) then
        exit
      end if
      me.mLaunchSFX([#member: EMPTY, #piste: pListEvent.PHOTO])
      pListEvent.PHOTO = VOID
  end case
end
